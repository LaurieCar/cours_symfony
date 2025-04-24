<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService{
    
    public function __construct(
        private readonly string $apikey,
        private readonly HttpClientInterface $httpClient
    )
    {}

    /**
 * @return array
 */
    public function getWeather()
    {
        $response = $this->httpClient->request('GET',
        'https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid='
        . $this->apikey . '&units=metric');
        $data = $response->getContent();
        $data = $response->toArray();
        return $data;
    }

    public function getWeatherByCity($city)
    {
        try {
            $response = $this->httpClient->request('GET',
            'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid='
            . $this->apikey . '&units=metric');
            $data = $response->getContent();
            $data = $response->toArray();
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("Ville non trouvée");
        }
        
    }
}
