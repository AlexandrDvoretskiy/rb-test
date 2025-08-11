# Summary

## Task 1: Add Category Feature to Books

Implemented category creation and storage functionality to enhance the book management system.

Implemented CRUD operations for categories.

`Task 1` was completed by designing a new symfony bundle called `categoryBundle` to showcase my approach to development.

As for the directory structure, I've slightly modified it and integrated the bundle's methods into the Bookstore to expand the app's capabilities.

Namely, I added the ability to assign a category to each book.

Twig templates were modified to display changes.

CRUD-operations can be tested by using Postman:
1. [RichBrains.postman_collection.json](/RichBrains.postman_collection.json)
2. [RichBrains.postman_environment.json](/RichBrains.postman_environment.json)

I also installed additional composer packages, such as:
```bash
webmozart/assert
symfony/serializer-pack
```

## Task 2: Fix the Description Saving Problem

I was able to identify and solve the description saving problem:
1. The `Length` Doctrine ORM attribute was increased from 80 to 4096
2. The `substr` php method was deleted from `app/src/Form/BookType.php`

## Bonus point

On top of that, I wrote a few tests using `PHPUnit`.

Execution command:
```bash
vendor/bin/phpunit --testdox
```

## Challenges

1. `crlf` line separator: used `dos2unix` package to change it
2. Choosing an optimal task solution

## Execution time 

I spent about 12 hours on development, an hour and a half on creating the summary and around 4 hours on writing the tests.