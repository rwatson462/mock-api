# mock-api
API mocking service where you define the contract of the responses of your API to validate your other services

## Tech stack
* Docker compose container
* PHP 8.2 (beta) built-in server
* INI files for configuration
* Anything you like as output files

## Configuration
To configure the API responses, you need to set up 2 things:
1. In the `config/routes` directory, create a file that looks like this:
   ```
   ; The name of the route is used when parsing the routes if an error is encountered
   [route name]

   ; The URL you'll use to access your response
   path=/path/to/your/end-point

   ; The HTTP status code that'll be returned with the response
   status=200

   ; HTTP method(s) that will be accepted by the end point
   method=POST
   ; You can also accept multiple methods using:
   ;methods[]=POST
   ;methods[]=GET

   ; Response headers to be set when sending back
   headers[content-type]=application/json
   headers[x-powered-by]=mock-api

   ; Finally, a filename to direct to the response file
   response=end-point.json
   ```
2. In the `responses` directory, place files (any file you like) to represent the response that will get sent back to the client.  These are the files referenced in the `response` section of the route configuration.