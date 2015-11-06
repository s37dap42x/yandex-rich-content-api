# Yandex Rich Content API

Client for Yandex Rich Content API

The Rich Content API provides access to the Yandex content system, containing tens of billions of pages. For any of them, you can receive the snippet, title and URL in canonical form, as well as the complete text and also a list of links to the images and videos they contain. This API is useful for services whose users exchange links. It allows them to see a preview of any web page without leaving the service.

[API reference](https://tech.yandex.com/rca/)

# Versioning

Package version corresponds to the version of the API.

# Installation
Use composer:

`composer require s37dap42x/yandex-rich-content-api`

or manually add into your `composer.json`:

```json
{
  "require": {
    "s37dap42x/yandex-rich-content-api": "^1.1"
  }
}
```

and then use the update command:
`composer update`

# Usage

[Get your own api key](https://tech.yandex.com/keys/get/?service=rca)

```php
use Yandex\RichContentAPI\RichContent;

$key = "rca.1.1...";
$url = "http://yandex.com";

try {
    $yandex = new RichContent($key);
    $data = $yandex->getContent($url);
    var_dump($data);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

#License

[MIT](LICENSE)