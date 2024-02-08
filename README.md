# Web-Application with Database - KinfemichaelDesse

Desse, Kinfemichael, 
&nbsp; &nbsp; Matriculation no. 00813759

[Link to the repository](https://mygit.th-deg.de/kd26759/web-application-with-database-kinfemichaeldesse)

## Project description
This platform provides a customer to customer service for students to sell and buy their used books.
Students can register on the site and look through existing offers and bid their price on the offers.
Registered students can also create their offer so other can bid in.

## prerequisite
* [docker](https://www.docker.com/products/docker-desktop/)

## Code base and structure
> `index.php` file holds all the required routes and paths

> `Controllers` directory includes all the classes defined to interact with database and the view

> `Models` directory holds all the schema definitions of the application

> the front end pages resides in the `views` directory

> `assets` directory holds all the static resources needed. i.e. `css`, `js`, and, `images`.

> `api` directory holds all the endpoints defined for rest api used by the front end javascript ajax requests.

> `Dockerfile` holds the definition for the docker environment

> `docker-compose.yml` holds the configuration and environment definition needed for docker to run the containers and images

> necessary environmental variables are defined in the `.env` file.

### Directory structure
\
&nbsp;&nbsp;<img width="227" alt="Screenshot 2023-01-02 at 13 58 46" src="https://user-images.githubusercontent.com/44194230/210234541-2851968a-c0a4-49d6-b88c-b14247246bdc.png">&nbsp;


## Installation
* first clone the repository

* copy `.env.example` to `.env` and add the required environment variables
``` 
 cp .env.example .env
```

* I have created a contenerized environment to build and run the application. Instead of configuring a xamp environment we are running this application inside a dockerized containers.

* to build the image and necessary containers

``` 
docker build . 
```

* to run the app and server
``` 
docker-compose up
```

## Basic Usage

Users can view the books from other users without login. To send a mesasge or post own offer, user needs to login/register on the portal. There are different categories for different books. User can use filter as well to sort out the ads as per requirement.

### Use cases
1. Parsing through available offers for a specific item. (no login needed)
2. Users can search for item or filter the offers based on categories (no login needed)
3. users can register on the portal and become a memeber. to register users need a valid email address. on the database users name email and password will be saved.
4. registered users can login 
5. registered users can create an offer, edit their offer and delete their offer.

7. registered users can edit their profile which includes changing profile picture, updating passwords and name and also delete their profile.

8. users can add books on cart
9. users can remove books from cart


### Project Demo

<img width="1498" alt="Screenshot 2023-01-02 at 14 03 30" src="https://user-images.githubusercontent.com/44194230/210235088-71348399-1759-4df2-b94f-7c5684b21efa.png">


<img width="1508" alt="Screenshot 2023-01-02 at 14 04 21" src="https://user-images.githubusercontent.com/44194230/210235184-5dbf48fc-098a-4a95-8a5b-9925fed0791c.png">


<img width="1498" alt="Screenshot 2023-01-02 at 14 06 51" src="https://user-images.githubusercontent.com/44194230/210235461-608189f1-0b5f-4eab-b26f-146e3d9a4b6d.png">


<img width="1498" alt="Screenshot 2023-01-02 at 14 07 29" src="https://user-images.githubusercontent.com/44194230/210235526-37f9db76-77a4-40f0-b3d2-c6cc6174ce4a.png">

<img width="1508" alt="Screenshot 2023-01-02 at 14 08 19" src="https://user-images.githubusercontent.com/44194230/210235613-5b0cbf64-edae-4264-b80b-d68dab3d286a.png">
<img width="1509" alt="Screenshot 2023-01-02 at 14 09 19" src="https://user-images.githubusercontent.com/44194230/210235731-ffc1fac4-4872-49b5-a631-89842c3d6d9a.png">

