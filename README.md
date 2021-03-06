![Logo](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/th5xamgrr6se0x5ro4g6.png)


# Evernet SEO CRM

A brief description of what this project does and who it's for


## Run Locally

Install Symfony and Composer packages on your OS

For __.pdf__ generation support install [wkhtmltopdf](https://wkhtmltopdf.org/) package.

Clone the project

```bash
  git clone https://link-to-project
```

Go to the project directory

```bash
  cd EvernetSEO
```

Install dependencies

```bash
  composer install --optimize-autoloader
```

Generate configuration file (.env.local.php)

```bash
  composer dump-env prod
```

Check generated configuration is suited for your preferred project environment

If there is no 'admin' table entries presented in project DB:

- generate app-hashed password

```bash
  symfony console security:hash-password
  # or
  php bin/console security:hash-password
```

- add  entry in 'admin' table with generated password from previous step

```SQL
INSERT INTO admin (id, username, roles, password) \
VALUES (nextval('admin_id_seq'), 'admin', '[\"ROLE_ADMIN\"]', <your_generated_password>);
```

Start the server

```bash
  # with Symfony package presented in OS 
  symfony server: --port=8080
  # or without Symfony
  php server: --port=8080
  # Built-in server also works
  php -S localhost:8080 -t public/
```

## Environment Variables

To run this project, you will need to add the following environment variables to your .env.local.php file

`API_KEY`

`ANOTHER_API_KEY`


## Running Tests

To run tests, run the following command

```bash
  npm run test
```


## Features

- Light/dark mode toggle
- Live previews
- Fullscreen mode
- Cross platform


## Roadmap

- Additional browser support

- Add more integrations


## Appendix

Update translation entries list (for RU locale).

```bash
  symfony console translation:update ru --force --domain=messages
```
____

getVisitsViewsUsers == getVisitors
getTopPageViews == getMostViewedPages
getTechPlatforms == getBrowsers
getVisitsUsersSearchEngine == getUsersSearchEngine
getGeoCountry == getGeo
getAgeGender -- in project
____
getSourcesSummary
getSourcesSearchPhrases
getVisitsViewsPageDepth
getGeoArea


## Acknowledgements

- [Awesome Readme Templates](https://awesomeopensource.com/project/elangosundar/awesome-README-templates)
- [Awesome README](https://github.com/matiassingers/awesome-readme)
- [How to write a Good readme](https://bulldogjob.com/news/449-how-to-write-a-good-readme-for-your-github-project)


## Authors

- [@avsuloev](https://github.com/avsuloev)
    - [mail](mailto:av.suloev@outlook.com)
    - [Telegram](https://t.me/alexanderWebDev)
