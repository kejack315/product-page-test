# Product Page Task

Find the requirements for your task:  
- [Backend Requirements](./requirements/backend/README.md)
- [Frontend Requirements](./requirements/frontend/README.md)

> Note: If you are applying for a full stack role. Please see both of the above requirements.

Run php artisan serve
GET TOKEN(Using POSTMAN):

> Register http://127.0.0.1:8000/api/register
{
"name": "John Doe",
"email": "john@example.com",
"password": "your_password",
"password_confirmation": "your_password"
}

> Login http://127.0.0.1:8000/api/login
{
"email": "john@example.com",
"password": "your_password"
}
>copy "token you get"

CRUD TEST
> Authorization:Bearer "token you get"
> Read(GET)
http://127.0.0.1:8000/api/products
http://127.0.0.1:8000/api/products/'product_id'
> Creat(POST)
http://127.0.0.1:8000/api/products
> Update(PUT)
http://127.0.0.1:8000/api/products/'product_id'
body eg
{
"name": "Product Name",
"description": "Product Description",
"slug": "product-slug",
"price": 100,
"active": true,
"discount": {
"type": "percent",
"amount": 50
}
}
> Delete(DELETE)
http://127.0.0.1:8000/api/products/'product_id'
