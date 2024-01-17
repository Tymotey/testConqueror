# Purpose of test:

Create simple server in PHP with database and show a list of items from this database.
Add frontend functionality that will allow clients to add items to cart.
After items are added to cart, show a checkout page with total calculations.
Must be quick and optimized for high traffic.

# Deploy:

-   clone GIT from link [https://github.com/Tymotey/testConqueror](https://github.com/Tymotey/testConqueror)
-   create database. Compatible collation: utf8mb4_general_ci
-   import database from file: **sql/db.zip** to newly created database. Example data will be imported too.
-   change access to database in file **config.php**, variables: DB_NAME, DB_USER, DB_PASSWORD, DB_HOST
-   apache access(user and pass): theconqueror
