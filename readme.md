## Installation Instructions

1. Assuming composer is installed on your server, php(>=7.1.3) is recognised on your server via cmd. 
2. After downloading the git repository naviagte to directory samtest.
3. copy `.env.example` and rename it to `.env` and keep on same root as `composer.json`.
4. change `DB_DATABASE=sammedia, DB_USERNAME=root, DB_PASSWORD=123456` values as per your database server credentials.
5. Run Command `php -r "require 'vendor/autoload.php'; echo str_random(32).PHP_EOL;"` via cmd to generate your APP_KEY and replace in your .env file.
6. Run command `composer update` it will download all the composer dev dependencies and repositories.
7. Run command `php artisan migrate` for creating all tables in your database.
8. Run command `php artisan db:seed` for seeding the dummy data related to this test.
9. Run command `php -S localhost:8000 -t public` to load your local server.
10. Hit the URL `http://localhost:8000/` in your browser/POSTMAN.
11. If all installation steps done correctly you will see `Lumen (5.8.4) (Laravel Components 5.8.*)` in browser/POSTMAN.

### APP End Points

1. Generate Token - GET `api/v1/auth/login` {"email": "faisal.siddiq87+user02@gmail.com", "password" : "123456"}
2. Get all Orders - GET `api/v1/order`
3. Create Order   - POST `api/v1/order/create` {"products" : ["5", "6"],"amount" : "440.20"}
4. Check Order Status - GET `api/v1/check-status/1`
5. Cancel Order - PUT `api/v1/cancel-order/1`
6. Process Payment - POST `api/v1/payment` {"order_id" : 11,"amount": "430.20"}
7. Please send the token generated from `api/v1/auth/login` End Point in headers while calling each End point like
`Authorization => Bearer token_retrieved_from_auth_login_EP`

### Testing End Points

1. After you have seeded data and created some orders and few payments are processed test your End points.
2. Run the Command `vendor/bin/phpunit` on your project root.
3. All the test cases should return OK with assertions.

### About Development

1. Laravel PHP framework is used for building all the RESTFul webservices.
2. Jwt Authentication package is added for securing all the End Points.
3. All the order/payment End points are secured via jwt auth middleware.
4. Api rate limiting/throttling is applied on All End Points.
5. SOLID principles(Services/Repositories) are used to implement the microservices architecture.
6. Proper request input validation is used in all End points for validating input data before processing any next step.
7. Have followed Proper PSR standards/Code Styling/Naming conventions.
8. Have tried to write optimized/generic code as much as possible.
9. Any change/suggestion in the code/architecture is welcome.

## General Scenario 

1. As you Call Order's App endpoint(`api/v1/order/create`) to create an Order.
2. Order will be created in DB with the created state.
3. If Order is created successfully, Orders App will make a call to Payment App with order information and auth details.
4. Payment App will processes an order and returns response confirmed or declined.
5. Orders App updates order based on the response from the Payments App
   * declined ⇒ will move order to the canceled state
   * confirmed ⇒ will move order to the confirmed state
6. Logic i have added behind payment confirmed or declined is if the input amount from create order EP is equal to Products price payment will be confirmed else will be declined
7. After X amount of seconds confirmed orders will be automatically moved to the delivered state status via MYSQL Events(The MYSQL Event is already added in database when you run db migrations while project setup).


## Other Notes:

1. In My views all the points as per task requirement are done, still if you think any thing i missed let me know i will add that and push in to this repo.
