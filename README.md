## Vagrant Installation Instructions

1. To Install Vagrant on your machine follow these steps
2. Virtualbox download link: https://www.virtualbox.org/wiki/Downloads
3. vagrant download link: https://www.vagrantup.com/downloads.html
4. After downloading these, first install virtualbox. And then install vagrant. 
5. You may need to restart your PC after the installation complete.
6. Git bash Download link: https://git-scm.com/download/win
7. Now open git bash in administrator mode and run the following command: `vagrant box add laravel/homestead` and select `virtualbox` option
8. it should add the laravel/homestead box to your Vagrant installation. It will take a few minutes to download the box, depending on your Internet connection speed.
9. Now, after completing down load, from Git bash type cd ~ on you git bash and hit enter. Now run the following command:
`git clone https://github.com/laravel/homestead.git Homestead`
10. It will clone the Homestead repository into a Homestead folder within your home (C:\Users\USER_NAME) directory.
11. Now run the following two commands one by one: `cd Homestead` and `bash init.sh`
12. This will create the Homestead.yaml configuration file. 
13. The Homestead.yaml file will be placed in the C:\Users\USER_NAME\Homestead directory.
14. Now we need ssh key. To check it is already exist in your computer or not go to C:\Users\USER_NAME\ directory and try to find out a folder named .ssh. If it exists, go into the folder and try to find out two files named id_rsa and id_rsa.pub. If the folder .ssh doesn’t exist or the folder exists but the two files named id_rsa and id_rsa.pub doesn’t exist then run the following command:
`ssh-keygen -t rsa -C “your_email@example.com”`
15. then the command prompt will ask you two things. you don’t need to type anything, just press enter what ever the command prompt ask you. After finishing this command a new .ssh folder (if already not exist) will be created with the two files named id_rsa and id_rsa.pub into it.
16. Now we are going to edit the Homestead.yaml file which is generated already in  C:\Users\USER_NAME\Homestead directory
17. First of all change ssh info in Homestead.yaml and they should look like this after change
`authorize: c:/Users/USER_NAME/.ssh/id_rsa.pub`
`keys:`
 `— c:/Users/USER_NAME/.ssh/id_rsa`
18. Don’t forget to use the lowercase of you drive name(c instead of C) and forward slash(/) instead of back slash(\). 
19. Now modify folders like
`folders:`
 `— map: e:/Your_project_Dir`
` to: /home/vagrant/Code`
20. See now? my PC’s e:/Homestead_Projects folder and vagrant’s /home/vagrant/Code folder are pointing to the same folder.
21. Now modify sites like
sites:
` — map: homestead.app`
 `to: /home/vagrant/Code/Laravel/public`
22. Now windows will not allow the homestead.app link to be hit from browser. 
23. For that goto C:\Windows\System32\drivers\etc\ folder and edit the hosts file like
24. 192.168.10.10 homestead.app
25. Now navigate to cd ~/Homestead and hit `vagrant up` to start vagrant virtual box

## Vagrant Installation Instructions

1. After downloading the git repository naviagte to directory samtest.
2. copy `.env.example` and rename it to `.env` and keep on same root as `composer.json`.
3. Run Command `php -r "require 'vendor/autoload.php'; echo str_random(32).PHP_EOL;"` via cmd to generate your APP_KEY and replace in your .env file.
4. Navigate to `cd ~/Homestead` and type `vagrant ssh`
5. Now type `cd ~/code/sam/samtest`
4. Run command `composer update` it will download all the composer dev dependencies and repositories.
5. Run command `php artisan migrate` for creating all tables in your database.
6. Run command `php artisan db:seed` for seeding the dummy data related to this test.
7. Hit the URL `http://homestead.app` in your browser/POSTMAN.
9. If all installation steps done correctly you will see `Lumen (5.8.4) (Laravel Components 5.8.*)` in browser/POSTMAN.

### APP End Points

1. Generate Token - POST `api/v1/auth/login` {"email": "faisal.siddiq87+user02@gmail.com", "password" : "123456"}
2. Get all Orders - GET `api/v1/order`
3. Create Order   - POST `api/v1/order/create` {"products" : ["5", "6"],"amount" : "440.20"}
4. Check Order Status - GET `api/v1/check-status/1`
5. Cancel Order - PUT `api/v1/cancel-order/1`
6. Process Payment - POST `api/v1/payment` {"order_id" : 11,"amount": "430.20"}
7. Please send the token generated from `api/v1/auth/login` End Point in headers while calling each End point like
`Authorization => Bearer token_retrieved_from_auth_login_EP`

### Testing End Points

1. After data is seeded and some orders are created test your End points.
2. Navigate to cd ~/Homestead and type vagrant ssh
3. Now type cd ~/code/sam/samtest
4. Run the Command `vendor/bin/phpunit` on your project root.
5. All the test cases should return OK with assertions.

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
6. Logic added behind payment confirmed or declined is if the input amount from create order EP is equal to Products price payment will be confirmed else will be declined
7. After X amount of seconds confirmed orders will be automatically moved to the delivered state status after X seconds via MYSQL Events(The MYSQL Event is already added in database when you run db migrations while project setup).


## Other Notes:

1. In My views all the points as per task requirement are done, still if you think any thing is missed let me know will add that.
