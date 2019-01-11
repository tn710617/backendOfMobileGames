[English](./README.md) | 繁體中文

<h1 align="center">web端儲值平台以及Mobile端遊戲後台</h1>
<br/>
<br/>

## 串接的Mobile遊戲GitHub連結如下 
- https://github.com/ytyubox/GIFStop-goodIdea
- https://github.com/shya008/LoveLetterGenerator
- https://github.com/River9751/EscapeRoom

## 文件連結如下 
- https://tn710617.github.io/API_Document/backendOfGameAndOnlineDepositingSystem/

## Web版 / Web side
- 線上會員系統: 可註冊，登入，登出
- 線上第三方支付系統: 透過第三方支付支援線上儲值
- 點數異動明細: 登入後可在網頁顯示所有點數異動明細
- 訂單明細: 登入後可顯示訂單明細

## APP端 / APP side
- 會員系統
    - 註冊： 提供註冊API
    - 登入： 提供登入API
    - 玩遊戲： 登入遊玩時，扣點並顯示餘額，剩餘點數需大於遊戲需求點數
    - 已購買物品明細： 顯示已購買物品
    - 個人資料區：顯示個人資料，餘額，所有已達成的個人成就，共同成就，購買物品
        - 顯示個人資訊
        - 顯示剩餘點數
        - 顯示已達成個人成就
        - 顯示已達成共同成就
        - 顯示已購買商品
        
- 成就系統: 
    - 個人成就： 遊戲端可依照遊戲特性自定義成就，分為一次性成就以及可多次達成型成就，除現有成就外，支援新增成就擴充。  
    - 共同成就： 可針對相同帳號下遊玩的所有遊戲做成就達成紀錄並計算，若滿足條件則觸發共同成就，除現有成就外，支援新增成就擴充。
- 商城系統：
    - 一次性商品： 購買後立即生效，支援新商品擴充
    - 可重複購買商品： 可帶入欲購買數量，支援新商品擴充
    
## 安裝步驟(終端機)：
 1. git clone `git@github.com:tn710617/backendOfMobileGames.git`
 2. 輸入：`cd backendOfMobileGames`
 `composer install`
 3. 創建您自己的資料庫。
 4. 輸入: `cp .env.example .env`
 `vim .env`，並輸入您自己的資料庫配置。
 5. 輸入：`php artisan key:generate`
 6. 輸入：`php artisan migrate`
 7. 修改以下.env參數：
    - ReturnURL=yourURL/api/paymentResponse
    - ClientBackURL=yourURL
 8. 可在資料庫新增個人成就以及共同成就
 9. 希望您有好的使用體驗。
 
 更詳盡的資訊請參考文件如下：
 `https://tn710617.github.io/API_Document/backendOfGameAndOnlineDepositingSystem/`
