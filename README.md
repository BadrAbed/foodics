# Restaurant creating order service

## Installation

### Docker

To install with Docker using [Laravel Sail](https://laravel.com/docs/10.x/sail), follow these steps:

1. Clone the repository:

    ```
    git clone https://github.com/BadrAbed/foodics.git
    cd foodics
    ```

2. Start the Docker containers :

    ```
   docker-compose up --build
    ```

3. Copy the `.env.example` file to `.env`:

    ```
    cp .env.example .env
    ```

4. install composer :

    ```
    composer install
    ```

5. Generate an application key:

    ```
     php artisan key:generate
    ```

6. Run the database migrations and seed the database:

    ```
     php artisan db:seed
    ```

7. Start the queue worker to process email notifications:

    ```
     php artisan queue:work
    ```

## Code overview

The main components of the application are:

- `app/Http/Controllers/Api/V1/OrderController` - The controller responsible for handling order creation requests
- `app/Http/Controllers/Api/ApiBaseController` - base class for apis to handle response 
- `app/Http/Requests/StoreOrderRequest` - The request validation class for validating the order creation request
- `app/Mail/LowIngredientStock` - The email notification sent to the ingredient merchant when an ingredient falls below a certain threshold
- `app/Services/OrderService` - The service class that encapsulates the business logic for creating an order
- `database` - The directory that contains the database migration, factory, and seeder files
- `routes/api` - API routes
- `tests/Features/OrderTest` - The feature test class that tests the common scenarios for creating an order

## APIs

### Create Order

POST /api/orders

Request body example:

```json
{
    "products": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ]
}
```

## Feature Testing for API

To run the feature tests, run the following command:

```
php artisan test
```
