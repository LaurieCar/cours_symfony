<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    public function __construct(
        private readonly WeatherService $weatherService
    )
    {}

    #[Route('/weather', name: 'app_weather')]
    public function weather(): Response{
        
        $weatherData = $this->weatherService->getWeather();
        return $this->render('weather/weather_api.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }

    #[Route('/weather/city', name: 'app_weather_city')]
    public function weatherCity(Request $request) {
        $weatherForm = $this->createForm(WeatherType::class);
        $weatherForm->handleRequest($request);

        $weatherData = null;
        $error = null;
        
        if ($weatherForm->isSubmitted() && $weatherForm->isValid()) {
            $city = $weatherForm->get('city')->getData();
            
            try {
                $weatherData = $this->weatherService->getWeatherByCity($city);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
            
        }
        return $this->render('weather/weather_api.html.twig', [
            'weatherForm' => $weatherForm,
            'weatherData' => $weatherData,
            "error" => $error
        ]);
    }
}
