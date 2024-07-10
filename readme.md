Aim:
* Create migration tool using native PHP

Requirements:
* OS with docker installed on it

RUN FOR FIRST TIME FROM THE ROOT FOLDER

    bash ./scripts/run.sh

For installing dependencies run from container terminal

    cd /var/www/html
    composer require

RUN FOR REBUILD (also from the root folder)

    bash ./scripts/build_run.sh

For running migrations:
1. exec sh in your docker container
2. change sh working directory into /var/www/html/Migrations
3. Add some files into folder files (or as a first time you may do anything cause some files are here)
4. For upping all migrations run command php Run.php up
5. For downing all migrations that were applied run command Run.php down
