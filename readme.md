# OpenWeatherMap API Module

Collects data from service http://api.openweathermap.org/data/2.5/weather  

API documentation: https://openweathermap.org/current  

Weather information collected by City ID.  
List of city ID `city.list.json.gz` can be downloaded here http://bulk.openweathermap.org/sample/

## Configuration
System configuration:
`Stores > Configuration > Services > OpenWeatherMap API`
1. **Enabled** - field defines if service enabled on website (Default value: NO)
2. **Weather API Service Url** - URL of service (Default value: http://api.openweathermap.org/data/2.5/weather)
3. **Token** - Secret key, configure your own key under the link https://home.openweathermap.org/api_keys. (My token can be used for tests: 6ee0a63acf1dc2cb21fdddadd017f98e)
4. **City** (Possible values: Lublin, London. Default value: Lublin)
5. **Units** (Possible values: Metric, Imperial. Default value: Metric)
6. **Test Connection** button - Use it for checking if API is configured correctly (In case any changes of API configuration please remember to save configuration before test connection)

## Cron job
In order to fetch data from API to magento database cron job is configured (runs each 10 minutes)
Process of pulling data from OpenWeatherMap API runs only for websites where option is **Enabled**

## Frontend weather report
Weather information is available on frontend page under the link `http://example.com/weather/report`

## Historical Weather Information
Historical Weather Information is available in the Admin Panel under the path:
`Content > Weather > Weather Report`
