# ravecheckout-php
- Your Own Hosted Simple REST API to Integrate flutterwave payment including live payment verification
   -  @Author: Emcode

# SETUP GUIDE

- Clone this repo in any PHP server environment or CPANEL as the backend is written in PHP. Any language can consume this API

- Create a file outside  your project to store your flutterwave secret key
  - E.g /home/ur_cpanel_username/ravesecret.txt

 - Generate your own unique reference in a table. 

    E.g example invoice_table 

        id user_id reference amount customer_email status

        1   23      Q89D      3000   ex@gmail.com   unpaid

- Make a post request using any language or REST CLIENT to the file ravepay.php. 
  - E.g  https://ur-domain.com/ravecheckout-php/ravepay.php
        
  Request Object: 
  ```json
        { 
            "email": "ex@gmail.com", 
            "reference": "Q89D", 
            "public_key": "FLWPUBK-71543e3a8648e7f1cb51f3bc9522170c-X",
            "amount": "3000", 
            "allow_redirect": "no",
            "redirect_url": "https://digimart.pro",
            "product_name": "Wallet fund or buy shoe",
            "product_description": "nice one",
            "custom_logo": "https://cdn.pixabay.com/photo/2016/09/14/20/50/teeth-1670434_960_720.png"
         }
    ```

  - Response: The response is a payment link which you can call on iframe pop or just redirect by setting 
    allow_redirect: 'yes'  in the request object
# PAYMENT VERIFICATION
   - Make a post request using any language or REST CLIENT to the file verify.php. 
   
   - E.g  https://ur-domain.com/ravecheckout-php/verify.php
        
          Request Object: 
        ```json
            {
                 "reference": "Q89D"
            }
        ```
        - RESPONSE Object: 
            {
               details of the transaction
            }
## You can setup a cronjob to call this endpoint 

# SUPPORT IS AVAILABLE
   - If you need quick help in setting up very secure flutterwave payment on your CPANEL account.

      Just email me: eeema9@gmail.com

# SUPPORT FEE IS JUST N15,000
   - Pay To: 
        Name: Emanovwe Emmanuel Junior 

        BANK: GTB 

        Account No: 0033033067

    - Just email me a proof of payment. Then you have my support to help you personally.

# EMAIL CONTACT: eeema9@gmail.com

# 



 


