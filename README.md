# Eredivisie Dashboard
This is a programming assignment created to demonstrate skills and resourcefulness using a new framework . It is based on a DDEV environment and the use of the Symfony framework.

## Pre-requisites
- Install [DDEV](https://ddev.readthedocs.io/en/stable/)
- Go to https://www.football-data.org/, create an account and get an API key
## Usage
This is a template for the application development for the internship assignment. This environment is set up with [DDEV]([https://ddev.readthedocs.io/en/stable/](https://ddev.com/get-started/)). Install this software to make use of this development environment.

Create a new personal repository based on this template

![Screenshot 2024-04-09 at 10 34 28](https://github.com/recranet/internship-assignment-template/assets/36085765/90d8b4a0-8d2e-43c2-8677-3158270ee716)

Once you have cloned this repository on your computer, you can use the following commands:

`ddev start` This command starts the local development environment.

`ddev stop` This command stops the local development environment.

To develop in the application, you can use the `ddev ssh` command. This opens a terminal session in the virtual development environment. Here you can run the `composer install` command to install the dependencies and use other symfony commands.

With DDEV, you can also use some commands directly, for example `ddev composer install` or `ddev symfony console cache:clear`. This way, you don't have to open a terminal session in the virtual development environment.

After starting the environment, you can use `ddev describe` to get the URL of the application. This URL can be used to access the application in the browser.

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