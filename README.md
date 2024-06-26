# Eredivisie Dashboard
This is a programming assignment created to demonstrate skills and resourcefulness using a new framework . It is based on a DDEV environment and the use of the Symfony framework.

## Pre-requisites
- Install [DDEV](https://ddev.readthedocs.io/en/stable/)
- Go to https://www.football-data.org/, create an account and get an API key
## Usage

Once you have cloned this repository on your computer, you can use the following commands:

`ddev start` This command starts the local development environment.

`ddev stop` This command stops the local development environment.

After starting the environment, you can use `ddev describe` to get the URL of the application. This URL can be used to access the application in the browser.

Use the following commands after starting the environment:

`ddev composer install` This command installs the dependencies of the project.

`ddev php bin/console doctrine:migrations:migrate` This command creates the database tables.

`ddev php bin/console sass:build` This command compiles the SCSS files to CSS.

Before retrieving the football data, we need to add the API key and the base uri to the .env file. This file is located in the root of the project. Add the following line to the file:

```
FOOTBALL_DATA_API_BASE_URI=http://api.football-data.org/
FOOTBALL_DATA_API_TOKEN=YOUR_API_KEY
```

Now we can retrieve the data from the football API. To do this, we can use the following commands:

```
ddev php bin/console app:get-teams
ddev php bin/console app:get-matches
ddev php bin/console app:get-standings
```

In a real-world application, we would use a cron job to retrieve the data at regular intervals. For this assignment, we will run these commands manually.

## Screenshots

![Screenshot 1](/assets/images/screens/screen_01.png?raw=true "Screenshot 1")

![Screenshot 2](/assets/images/screens/screen_02.png?raw=true "Screenshot 2")

![Screenshot 3](/assets/images/screens/screen_03.png?raw=true "Screenshot 3")
