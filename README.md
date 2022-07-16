<h1>HOW TO RUN APP</>


##
Requirements :
    <p>-	make sure the computer has installed php version at least 7.2.</p>
    <p>-	make sure the computer has installed composer   . Composer a depedency manager for php.</p>
    <p>-	make sure you have MySQL installed on your computer.</p>
    
    
##
- Clone the project https://github.com/adimarbun/aichat-api-test.git


- Create database  , example name 'aichatappdb'
![image](https://user-images.githubusercontent.com/57535407/179352869-18a667d5-9ca4-41fe-9172-ca2b3c52252e.png)

- Run " composer i " to install package

- Change env and adjust it with your database configuration

![image](https://user-images.githubusercontent.com/57535407/179352901-4e22e180-ed7a-4e43-8003-04ec14860065.png)


- Run " php artisan migrate:fresh --seed  "     to migrate table an seed data inital to database
 
- Run " php artisan serve " to running app

- On other terminal , run "php artisan schedule:work " to run cronjob scheduler



<h1>Documentation API</>

##

- API  Check Customer Eligable

This api checks whether the customer is eligible to get the voucher, if eligible , lock voucher and expired after 10 minutes if customer not submmit photo

![image](https://user-images.githubusercontent.com/57535407/179353567-f6044ea9-d21b-4f90-87b3-e36dd24c9017.png)

![image](https://user-images.githubusercontent.com/57535407/179353636-1b47d8b3-72bd-49f7-9638-70e2c0475340.png)


- API to chek photo submission

This api to check photo submmission, if eligble , alocate the voucher which already lock and not expired.   

![image](https://user-images.githubusercontent.com/57535407/179353773-3db08947-f6e3-415d-bd16-018630ce3cc3.png)

![image](https://user-images.githubusercontent.com/57535407/179353807-b7641b98-319c-4fa6-a500-390218ed9e41.png)



<h1>About Proses API</>

##

- API  Check Customer Eligable

![Cek Egiliable diagram](https://user-images.githubusercontent.com/57535407/179354311-90e91ff9-ae3d-4531-9baf-8e64dda11006.jpg)

- API to chek photo submission

![validate photo diagram-1](https://user-images.githubusercontent.com/57535407/179354363-7024ef9d-5104-4a04-87f3-9aa22089e94c.jpg)








