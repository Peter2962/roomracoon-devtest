# Roomracoon devtest

### What is it?
The program is a basic shopping list tool which implements basic CRUD.
It runs on a mini php framework created to showcase the knowledge of an MVC architecture or design pattern.

### Prerequisites (Setting up locally)
##### Before you begin the setup process locally, ensure that the following are installed on your system:

- Docker

### Installing dependencies

Once the project has been cloned, you would need to run the following:

1. `composer install` - This will install required dependencies.

### Running the program
You can either run the program using a running web server program e.g MAMP or use docker (It is recommended to use docker as the program was built using it).

To run the program using docker, navigate to the program directory and run the `run.sh` file.
This will run all required docker commands and start the program which can then be accessed via `http://localhost:8080`.

You can then access phpmyadmin at `http://localhost:8081`.
 TO login to phpmyadmin, use:
 username: root
 password: root

### Seeding

There is a seeder file that creates the table required by the program. It exists in `root/database/seeder.php`.
This file needs to be run in the container using `docker exec -it roomracoon-devtest php database/seeder.php`.

Please contact for more information.

Your fullstack engineer,
Peter.