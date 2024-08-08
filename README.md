# Discord Lookup API (PHP)

Bu basit PHP API'si, Discord kullanıcıları, botları ve sunucuları hakkında bilgi almanızı sağlar. `type` ve `id` parametrelerini kullanarak API'ye istek gönderebilirsiniz.

## Kullanım

```
your-domain.com/discord-lookup-api.php?type=TYPE&id=ID
```

## Parametreler

* **`type`:**  `user`, `bot` veya `server`
* **`id`:**  Kullanıcı, bot veya sunucu ID'si

## Örnekler

* **Kullanıcı Bilgisi:**

```
your-domain.com/discord-lookup-api.php?type=user&id=123456789012345678
```

* **Bot Bilgisi:**

```
your-domain.com/discord-lookup-api.php?type=bot&id=987654321098765432
```

* **Sunucu Bilgisi:**

```
your-domain.com/discord-lookup-api.php?type=server&id=135792468013579246
```

## Dönüş Değeri

JSON formatında veri.

## Önemli Notlar

* `$token` değişkenini kendi botunuzun tokeni ile değiştirin.
* Discord API'sinin kullanım koşullarına uyun.

## Lisans

GPL v3


# Discord Lookup API (PHP) - English

This simple PHP API allows you to retrieve information about Discord users, bots, and servers. You can make requests to the API using the `type` and `id` parameters.

## Usage

```
your-domain.com/discord-lookup-api.php?type=TYPE&id=ID
```

## Parameters

* **`type`:**  `user`, `bot`, or `server`
* **`id`:**  User, bot, or server ID

## Examples

* **User Information:**

```
your-domain.com/discord-lookup-api.php?type=user&id=123456789012345678
```

* **Bot Information:**

```
your-domain.com/discord-lookup-api.php?type=bot&id=987654321098765432
```

* **Server Information:**

```
your-domain.com/discord-lookup-api.php?type=server&id=135792468013579246
```

## Return Value

Data in JSON format.

## Important Notes

* Replace the `$token` variable with your own bot token.
* Comply with the Discord API Terms of Service.

## License

GPL v3
