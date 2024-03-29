# SQL Injection Lab (Dockerized)
This contains the PSU IST 415 SQL Injection lab wrapped in Docker Compose. To install Docker Compose on your system, install [Docker Desktop](https://www.docker.com/products/docker-desktop/).
## Getting Started
1. Clone this repo with `git clone https://github.com/bman46/SQL-Injection-Lab.git`
2. CD to the project root `cd SQL-Injection-Lab`
3. To set your version of the lab, modify the `VERSION` variable to match your assigned version in the `compose.yaml` file
4. Run the website with `docker compose up --build`
5. Navigate to [localhost port 8080](http://localhost:8080/) to access the website
6. Setup the database using the [database setup page](http://localhost:8080/database-setup.php)
7. Complete the lab

## Modifications
Should you need to make a modification to any of the files in this lab, press `ctrl-c` to shutdown the current docker compose session. Then you can make your changes and run `docker compose up --build` to run the lab with your changes. You will need to rerun the [database setup](http://localhost:8080/database-setup.php).
