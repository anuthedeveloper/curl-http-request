# curl-http-request

Custom CRUD http request using CURL made with ease

A custom http request developed using PHP

- Programming Language: PHP
- Uses CURL
- No External Package
- Allows for CRUD Operations:
  - Methods: (POST, PUT, GET, DELETE)
- Can be modified to allow PATCH and so on...

Requirements:

- PHP >=8
- run composer update

Additional Tips:

- Can be modified by developers
- It allows and require modification for sending files

Use Case:

- Examples on how to use: check the samples directory them modify endpoint
- Modify the index file in the root folder with your Variables like: HOST_API URL
- Accepts your API Key, Additional Headers, and also allows to make Authenticated requests with your accessToken

See: GET Request Sample in: samples/index.php

Updates

- Added config/base file
- Renamed request-samples to samples for all test cases
- Updated with env configuration file
- Improved the src/HttpReqeust

Test

```
    php -S localhost:8000
```
