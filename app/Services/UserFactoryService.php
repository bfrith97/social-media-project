<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

class UserFactoryService extends ParentService
{
    public static function handleImageAndName()
    {
        $client = new Client();
        try {
            $response = $client->get('http://personator.nmxldev.com');
            $personDetails = json_decode($response->getBody()
                ->getContents(), true);

            if (!isset($personDetails['data'])) {
                throw new Exception('Data not found');
            }

            $pictureUrl = $personDetails['data']['photo']['full_url'];

            // Check if directory exists or create it
            $directory = public_path('assets/images/avatars');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $filename = basename($pictureUrl);
            $path = $directory . '/' . $filename;

            $imageData = file_get_contents($pictureUrl);
            if ($imageData !== false) {
                file_put_contents($path, $imageData);
                $name = $personDetails['data']['first_name'] . ' ' . $personDetails['data']['surname'];
                $picture = 'assets/images/avatars/' . $filename; // Relative URL for web access
            } else {
                throw new Exception("Failed to download image");
            }

            return [$name, $picture];

        } catch (Exception $e) {
            // Handle the case where the external image could not be downloaded or data was not found
            $avatar = new Avatar();
            $name = fake()->firstName() . ' ' . fake()->lastName();
            $generatedAvatar = $avatar->create($name);

            $filename = Str::slug($name) . '.png';
            $path = public_path('assets/images/avatars/' . $filename);

            $generatedAvatar->save($path);

            $picture = 'assets/images/avatars/' . $filename;

            return [$name, $picture];
        }
    }
}
