# automanager-todo

1. Clone the repository.
2. Install Composer dependencies

    `composer install`
    
3. Install JS dependencies
   
   `yarn && yarn dev` or `npm install && npm run dev`
   
4. Generate encryption key
    
    First run `cp .env.example .env`, <br>
    then run `php artisan key:generate`
    
5. Migrate the database
    
    `php artisan migrate`
