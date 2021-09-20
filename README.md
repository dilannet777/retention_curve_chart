## Weekly Retention Curve - Laravel API

This API generates the json array to render retention curve chart for user onboarding analysis.

![Screen Shot 2021-09-20 at 12 28 00 PM](https://user-images.githubusercontent.com/80531625/133966823-2b41fcb9-c591-4c06-9976-3dbdcc9147f3.png)

### Prerequisites

* PHP 7.4
* Laravel Framework 7.30.4
* Composer 2.0.11

### Installation

composer update
Rename .env.example to .env.
```
php artisan key:generate
php artisan serve
```
RUN http://localhost:8000/api/chart/onboard in Postman app

### Data Source

JSON array, located in storage/json/export.json

### Testing
```
php artisan test
```

### Output

Demo : [Click Here](https://codeapi1.codesands.com/api/chart/onboard)

### Front-end code of presenting data on retention curve chart

GitHub URL : [Click Here](https://github.com/dilannet777/retention_curve_chart_vuejs_app)
