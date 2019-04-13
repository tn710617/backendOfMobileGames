English | [繁體中文](./README.zh-TW.md) 
<h1 align="center">Online depositing system and backend of mobile games.</h1>
<br/>
<br/>

## The link of the games that adapted this backend system are as follows:
- https://github.com/ytyubox/GIFStop-goodIdea
- https://github.com/shya008/LoveLetterGenerator
- https://github.com/River9751/EscapeRoom

## The link of document link are as follows
- https://tn710617.github.io/API_Document/backendOfGameAndOnlineDepositingSystem/

## Web side
- Membership management system: Register, login, logout
- Online depositing system: You could deposit online via third party payment service
- Details of Points: After login, you could access all the details of the Points
- Details of order: After login, you could access all the details of the orders you've placed

## APP side
- Membership management system:
    - Register: Register API is available
    - Login: Login API is available
    - Play Games: After login, you could call this API every time you play the game, it would check your remaining points. Your remaining points should be greater than the game's required points
    - Details of purchased items: Show what you've purchased.
    - Profile:
        - Display personal information
        - Display remaining points
        - Display accomplished achievements
        - Display accomplished common achievements
        - Display purchased items
        
- Achievement system: 
    - Personal achievement: You could define a customized achievement, it could be one-time achievement or aggregatable achievement. Except for existing achievements, it supports adding new achievements.
    - Common achievements: It will calculate all the achievements you've achieved among those games you've played under your account, if some specific event is achieved, it will trigger some common achievement. Except for existing common achievements, it also supports adding new common achievements.
        
- Shopping system:
    - One-time items: It will be effective immediately after it's purchased. It supports adding new items.
    - Aggregatable items: It supports aggregatable item buying with a required number. It supports adding new items.
    
 
## installing instruction (command line):
 1. git clone `git@github.com:tn710617/backendOfMobileGames.git`
 2. type `cd backendOfMobileGames`
 3. Create a database. 
 4. Enter `cp .env.example .env`
, and replace the parameters with your database setting.
 5. Enter `php artisan key:generate`   
 6. Enter `php artisan migrate`
 7. Revise the following parameters in .env file:
    - ReturnURL=yourURL/api/paymentResponse
    - ClientBackURL=yourURL
 8. You could add new personal achievements and common achievements in database
 9. Hope that you will be enjoying it.
 
 For information in detail, please refer to the documentation as follows:
 `https://tn710617.github.io/API_Document/backendOfGameAndOnlineDepositingSystem/`

