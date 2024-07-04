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

