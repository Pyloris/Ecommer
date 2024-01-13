<?php


// DB config
const DB_USER = 'root';
// const DB_PASS = 'secret01';
const DB_PASS = '';
const DB_NAME = 'ecom';
// const DB_HOST = 'mysql-server-container';
const DB_HOST = 'localhost';
const DB_PORT = '3306';
const DB_TYPE = "mysql";



// branding
const BRAND_NAME = "ECOMMER";
const BRAND_LOGO = ROOT . "/static/images/logos/logo.png";


// site wise config
const CURRENCY = "₹";

// email config
const APP_PASSWORD = "rfea ztmd dmpc dqof";


// payment gateway
const RZP_ID = 'rzp_test_cXWEjxO84Cp4iR';
const RZP_SECRET = 'wA9IYa8rSCU2kw8TAqbXre4o';

const SUCCESS_CALLBK = "httpss://localhost/Ecommer/payment_success";
const FAILURE_CALLBK = "http://localhost/Ecommer/payment_failure";


// company details
const COMPANY_NAME = "Ecommer";
const COMPANY_LOGO_URL = "https://i.ibb.co/6rGj44p/klaudia-malgorzata-gawrych-commission-02-3.jpg";
?>