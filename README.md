<p style="text-align: center;"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 💪 Analisis de Riesgo Nexen V2.0


## Installation

# go into app's directory
$ cd risk-analysis-backoffice

# install app's dependencies
$ composer install

```

---

## Use SQLServer

Copy file ".env.example", and change its name to ".env".
Then in file ".env" complete this database configuration:
* DB_CONNECTION=sqlsrv
* DB_HOST=127.0.0.1
* DB_PORT=1433
* DB_DATABASE=risk_analysis
* DB_USERNAME=sa
* DB_PASSWORD=

---

### Next step

``` bash
# in your root app directory
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate --seed

```

---

## Setup Authentication

In case of cloning for the first time.

__in your root app directory__

Run the following command one time only:


``` bash
php artisan passport:keys
```

### Next step

Generate personal access client

__in your root app directory.__

Run the following command:

``` bash
php artisan passport:client --password
```

__What should we name the personal access client? [Laravel Personal Access Client]__
> nexen

__Console response:__

INFO  Personal access client created successfully.
``` bash
Client ID ..................................... 1
Client secret .................... VYhUP9wzweghkCtGOkytF6XmSzrSdREqzj7wCTPl
```

Copy client id and client secret and paste .env (FRONTEND)

``` bash
VITE_APP_LOGIN_CLIENT_ID=2
VITE_APP_LOGIN_CLIENT_SECRET=miqigPqsZAyTlURyFl7tCegCF69NDddbN0EngYSH
```

## API Documentation.

- Use notations to describe every API endpoint via Controllers methods example:

``` bash
/**
    * @OA\Get(
    *      path="/api/users",
    *      summary="Users List",
    *      tags={"Users"},
    *      description="Users List Endpoint.",
    *      @OA\Parameter(in="header", required=false, name="application_id", @OA\Schema(type="integer")),
    *      @OA\Parameter(in="path", required=false, name="group", @OA\Schema(type="string")),
    *      @OA\Parameter(in="query", required=false, name="search", @OA\Schema(type="string")),
    *      @OA\Response(response=200, description="Successful request"),
    *      @OA\Response(response=422, description="Invalid payload"),
    *      @OA\Response(response=401, description="Unauthorized")
    * )
 */
 public function index(Request $request)
 {
```

- To describe APIs use Open API and L5 Extention documentation:

``` bash
/**   
    *   @OA\Post(
    *      path="/api/users",
    *      summary="Users Store",
    *      tags={"Users"},
    *      description="Create User Endpoint",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                  @OA\Property(property="name", type="string"),
    *                  @OA\Property(property="email", type="string"),
    *                  @OA\Property(property="password", type="string"),
    *                  required={"email", "password"}
    *             )
    *         )
    *      ),
    *      @OA\Response(response=201, description="Successful Created"),
    *      @OA\Response(response=422, description="Invalid payload")
    * )
    */
   public function store(Request $request)
   {
```

``` bash
/**
    * @OA\Put(
    *      path="/api/users",
    *      summary="Users Update",
    *      tags={"Manager", "User"},
    *      @OA\RequestBody(
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="email", type="string"),
    *              @OA\Property(property="password", type="string"),
    *          )
    *      ),
    *      @OA\Response(response=200, description="Successful request"),
    *      @OA\Response(response=422, description="Invalid payload"),
    *      @OA\Response(response=401, description="Unauthorized")
    * )
    */
   public function update(Request $request)
```

``` bash
/**
    * @OA\Schema(
    *      schema="UserRegistration",
    *      title="User Schema",
    *      @OA\Property(property="id", description="User ID", type="integer"),
    *      @OA\Property(property="team_id", description="Team ID", type="integer")
    *      @OA\Parameter(in="query", required=false, name="from", @OA\Schema(type="string", format="date", pattern="\d{4}-\d{2}-\d{2}", example="2023-01-01"), description="Start Date"),
    *      @OA\Parameter(in="query", required=false, name="to", @OA\Schema(type="string", format="date", pattern="\d{4}-\d{2}-\d{2}", example="2023-12-31"), description="End Date"),
    * )
    * @OA\Post(
    *      path="/api/register",
    *      summary="Registration",
    *      tags={"Auth"},
    *      description="Registration Endpoint.",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                      property="email",
    *                      type="string",
    *                      description="User email",
    *                 ),
    *                @OA\Property(
    *                      property="photo",
    *                      type="file",
    *                      description="User photo",
    *                 ),
    *                 required={"email"}
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *          response=200,
    *          description="Successful user registration",
    *          @OA\JsonContent(
    *              @OA\Property(
    *                property="data",
    *                type="object",
    *                ref="#/components/schemas/UserRegistration"
    *              )
    *         ),
    *      )
*/
   public function register(AuthRegistrationRequest $request)
   {
```
- https://swagger.io/specification
- https://github.com/DarkaOnLine/L5-Swagger



- Generate documentation file, run this command:

``` bash
php artisan l5-swagger:generate
```

- You can visit /api/documentation URL and discover a basic docs

---

### __Tools__

- PHP 8.2
- Web Server(Xampp or Laragon)
- SQLServer DB










