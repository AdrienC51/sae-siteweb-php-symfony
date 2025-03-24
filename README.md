# Pharmaceutical Website

## Authors 

PLATEL-LENTZ Mathis, 
BALEZ Théo, 
GOMES Raphaël, 
CADALEN Adrien,
BITSINDOU Emmanuel,
LECOURT HUMBERT Tom

## Project description

This project is a website ("Pharma") where you can buy products, see their description, and track their delivery. Thus, this website is aimed at pharmacies in  need of medication or other. For that, the pharmacies can make their account and see their purchase history. For buying, we add a filter system that allow you
to search a product with their name or prices. Finally, this website does have others obvious pages like the cart page and it use a complex database with SQL.
For us, we add admin accounts and admin interface, we them we can manage our stocks and database.
This project was created with Symfony and Composer on PhpStorm, we was working on common deposit with Git. We also use Discord and Planner.
For a local use, we have described below all the needs to make that work.

# Needs to run this project

A version of php >= 8.1.

## Installing `Symfony`

### Linux

Run 'wget https://get.symfony.com/cli/installer -O - | bash' to install [Symfony](https://symfony.com/).

### Windows

Run 'scoop install symfony-cli' with [Scoop](https://scoop.sh/) to install [Symfony](https://symfony.com/).

## Installing Composer 

Install Composer [here](https://getcomposer.org/).

# Start the projet with `Composer`

To use this project, start with
```bash
composer install
```

# Local Web Server

To start the local web server : 
```bash
composer start
```

Access to it with this URL : <http://localhost:8000/>


# Code checking

- We run this command to check the code with php cs fix : 
```bash
composer test:phpcs
```
- We run this command to check the code with twig cs fix :
```bash
composer test:twigcs
```
- We test all the controllers and twigs with codeception :
```bash
composer test:codeception
```

To run them all :
```bash
composer test
```

# Code fix

- We run this command to correct the code with php cs fix :
```bash
composer fix:phpcs
```
- We run this command to correct the code with twig cs fix :
```bash
composer fix:twigcs
```

# Database

Create your .env.local file and connect to your database then run
```bash
composer db
```
to create the database and create dummy data.
