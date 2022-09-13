# cargofly-mvc

This project is based on my custom MVC pattern-based framework. Requires tones of improvements.

For now the whole app is working, except live feature (real-time cargo tracking) which I may write in React. 

The structure consists of: Controllers,Forms (with form builder and form validator), Fixtures, Entites, Repositories, Services and templates (at the beginning views were based on custom classes, but eventually I decided to use Twig).

DASHBOARD
It's like eagle view of deliveries. Some stats and recent shipments.
![alt text](https://github.com/piotr979/cargofly-mvc/blob/main/preview_dashboard.jpg)

MANAGE ORDER
Each order (cargo) can be redirected, canceled or its status changed.
![alt text](https://github.com/piotr979/cargofly-mvc/blob/main/preview_order.jpg)
ORDERS
Table with all orders. It's possible to sort (asc/desc) and filter with search form.
![alt text](https://github.com/piotr979/cargofly-mvc/blob/main/preview_orders.jpg)
PLANES
New planes can be added to the fleet. 
![alt text](https://github.com/piotr979/cargofly-mvc/blob/main/preview_planes.jpg)
