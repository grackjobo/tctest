This began as a coding exercise to create a shopping cart with simple php using interfaces for discounts and shipping and ensuring totals were correct. I'm now pushing the cart into laravel and creating outbound calls to GPTplus eCommerce to inform the cusotmer experience and pricing determination. 

### To Do 

- [x] Composer
- [x] PHPUnit (Unit and integration tests)
- [x] PHPStan
- [x] Docker
- [x] Docker Compose
- [x] Dependency Injection
- [x] Strategy Pattern 
- [x] Sensible types 
- [x] Source control and code review
- [x] Good separation/encapsulation
- [x] Small accurate interfaces
- [x] Type hinting: Return Params
- [x] Type hinting: Return Values
- [ ] Github enviornment: Add php to lint.yaml in github workflow
- [ ] Fix github worflow
- [ ] Move code to laravel structure
- [ ] Move phpunit cases to laravel

Notes: 


Development Shopping Cart Application
========================================================

| Env | FrontURL | AdminURL |
| --- | :------- | :------- |
| DEV | https://app.exampleproject.test/  | https://app.exampleproject.test/backend/  |
| STG | https://stage.exampleproject.com/ | https://stage.exampleproject.com/backend/ |
| PRD | https://www.exampleproject.com/   | https://www.exampleproject.com/backend/   |

Other useful URLs on DEV:

* https://mailhog.exampleproject.test/
* https://rabbitmq.exampleproject.test/
* https://elasticsearch.exampleproject.test/

## Developer Setup

### Prerequisites:

* [Warden](https://warden.dev/) 0.6.0 or later is installed. See the [Installing Warden](https://docs.warden.dev/installing.html) docs page for further info and procedures.
* `pv` is installed and available in your `$PATH` (you can install this via `brew`, `dnf`, `apt` etc)

### Initializing Environment

In the below examples `~/Sites/exampleproject` is used as the path. Simply replace this with whatever path you will be running this project from. It is recommended however to deploy the project locally to a case-sensitive volume.

 1. Clone the project codebase.

 5. Load the site in your browser using the links and credentials taken from the init script output. 

    **Note:** If you are using **Firefox** and it warns you the SSL certificate is invalid/untrusted, go to Preferences -> Privacy & Security -> View Certificates (bottom of page) -> Authorities -> Import and select `~/.warden/ssl/rootca/certs/ca.cert.pem` for import, then reload the page.
    
    **Note:** If you are using **Chrome** on **Linux** and it warns you the SSL certificate is invalid/untrusted, go to Chrome Settings -> Privacy And Security -> Manage Certificates (see more) -> Authorities -> Import and select `~/.warden/ssl/rootca/certs/ca.cert.pem` for import, then reload the page.

### Additional Configuration

Information on configuring and using tools such as Xdebug, LiveReload, MFTF, and multi-domain site setups may be found in the Warden docs page on [Configuration](https://docs.warden.dev/configuration.html).

### Destroying Environment

To completely destroy the local environment we just created, run `warden env down -v` to tear down the project’s Docker containers, volumes, and (where applicable) cleanup the Mutagan sync session.
