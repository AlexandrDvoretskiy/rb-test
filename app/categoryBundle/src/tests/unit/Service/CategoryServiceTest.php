<?php

namespace CategoryBundle\Unit\Service;


use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Generator;

use App\Service\BookService;

use CategoryBundle\Domain\Entity\Category;
use CategoryBundle\Domain\Service\CategoryService;
use CategoryBundle\Domain\DTO\CreateCategoryDTO;
use CategoryBundle\Domain\DTO\UpdateCategoryDTO;
use CategoryBundle\Infrastructure\Repository\CategoryRepository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(\CategoryBundle\Domain\Service\CategoryService::class)]
class CategoryServiceTest extends TestCase
{

    // region Create

    /**
     * @throws Exception
     */
    #[Test]
    #[DataProvider('createTestCases')]
    public function create(CreateCategoryDTO $createCategoryDTO, int $expectedId): void
    {
        $categoryService = $this->prepareCategoryServiceCreate($expectedId);

        $category = $categoryService->create($createCategoryDTO);

        $this->assertEquals($expectedId, $category);
    }

    /**
     * @throws Exception
     */
    private function prepareCategoryServiceCreate(int $expectedId): CategoryService
    {
        $bookService = $this->createMock(BookService::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->expects($this->once())
            ->method('create')
            ->willReturn($expectedId);

        return new CategoryService($categoryRepository, $bookService);
    }

    public static function createTestCases(): Generator
    {
        yield 'Category created' => [
            new CreateCategoryDTO(
                'Category 1',
                10,
            ),
            1
        ];

        yield 'Second category created' => [
            new CreateCategoryDTO(
                'Category',
                20,
            ),
            2
        ];
    }

    // endregion

    // region Get
    /**
     * @throws Exception
     */
    #[Test]
    #[DataProvider('getTestCases')]
    public function get(Category|null $category, array $expectedResult): void
    {
        $categoryService = $this->prepareCategoryServiceGet($category);

        $category = $categoryService->get(1);

        $actualData = [];
        if (!empty($category)) {
            $actualData = [
                'title' => $category['title'],
                'sort' => $category['sort'],
            ];
        }

        $this->assertEquals($expectedResult, $actualData);
    }

    /**
     * @throws Exception
     */
    private function prepareCategoryServiceGet(Category|null $category): CategoryService
    {
        $bookService = $this->createMock(BookService::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->expects($this->once())
            ->method('findById')
            ->willReturn($category);

        return new CategoryService($categoryRepository, $bookService);
    }

    public static function getTestCases(): Generator
    {
        yield 'Category found' => [
            new Category(
                'Category 1',
                10
            ),
            [
                'title' => 'Category 1',
                'sort' => 10
            ]
        ];

        yield 'Category not found' => [
            null,
            []
        ];
    }

    // endregion

    // region Update

    /**
     * @throws OptimisticLockException
     * @throws Exception
     * @throws ORMException
     */
    #[Test]
    #[DataProvider('updateTestCases')]
    public function update(?Category $category, UpdateCategoryDTO $updateCategoryDTO, int $updateId, bool $expectedResult): void
    {
        $categoryService = $this->prepareCategoryServiceUpdate($category, $expectedResult);

        $category = $categoryService->update($updateId, $updateCategoryDTO);

        $this->assertEquals($expectedResult, $category);
    }

    /**
     * @throws Exception
     */
    private function prepareCategoryServiceUpdate(?Category $category, bool $expectedResult): CategoryService
    {
        $bookService = $this->createMock(BookService::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->expects($this->once())
            ->method('findById')
            ->willReturn($category);

        if ($expectedResult) {
            $categoryRepository->expects($this->once())
                ->method('update')
                ->willReturn($expectedResult);
        }

        return new CategoryService($categoryRepository, $bookService);
    }

    public static function updateTestCases(): Generator
    {
        yield 'Category found and update successful' => [
            new Category(
                'Category 1',
                10
            ),
            new UpdateCategoryDTO('New Category 1', 20),
            1,
            true
        ];

        yield 'Category not found' => [
            null,
            new UpdateCategoryDTO('New Category 2', 1),
            9,
            false
        ];
    }

    // endregion

    // region Delete

    #[Test]
    #[DataProvider('deleteTestCases')]
    public function delete(?Category $category, bool $hasBooks, int $id, bool $expectedResult)
    {
        $categoryService = $this->prepareCategoryServiceDelete($category, $hasBooks);

        $category = $categoryService->delete($id);

        $this->assertEquals($expectedResult, $category);
    }

    private function prepareCategoryServiceDelete(?Category $category, bool $hasBooks): CategoryService
    {
        $bookService = $this->createMock(BookService::class);
        $categoryRepository = $this->createMock(CategoryRepository::class);

        $categoryRepository->expects($this->once())
            ->method('findById')
            ->willReturn($category);

        if ($category instanceof Category) {
            $bookService->expects($this->once())
                ->method('hasBooks')
                ->willReturn($hasBooks);

            if (!$hasBooks) {
                $categoryRepository->expects($this->once())
                    ->method('delete');
            }
        }

        return new CategoryService($categoryRepository, $bookService);
    }

    public static function deleteTestCases(): \Generator
    {
        yield 'Category found, no books, and delete successful' => [
            new Category(
                'Category 1',
                10
            ),
            false,
            1,
            true
        ];

        yield 'Category found, books exist' => [
            new Category(
                'Category 1',
                10
            ),
            true,
            2,
            false
        ];

        yield 'Category not found' => [
            null,
            false,
            3,
            false
        ];
    }

    // endregion

}