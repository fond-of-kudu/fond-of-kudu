# customer password changed at connector
[![license](https://img.shields.io/github/license/fond-of-kudu/discount-promotion-rest-api.svg)](https://packagist.org/packages/fond-of-kudu/discount-promotion-rest-api)

## What it does

This Composer package extends the Customer model by adding an additional column passwordUpdatedAt. This column stores the date and time of the customer's last password update. This allows developers to track the last password change of a customer and take appropriate actions, such as notifications about outdated passwords or enforcing password changes after a certain period.

Please note that the entire code is based on the Spryker Customer module. Only the function for setting a new password has been incorporated into this module.

## Installation

```
composer require fond-of-kudu/customer-password-updated-at-connector
```
