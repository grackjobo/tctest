<center><img width="690" alt="image" src="https://github.com/grackjobo/tctest/assets/79042620/5829d296-b176-40a6-abed-40b589832543"></center>


Development Thrivecart Application
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
 2. Foo
 3. Bar

 4. Run the init script to bootstrap the environment, starting the containers and mutagen sync (on macOS), installing the database (or importing if `--db-dump` is specified), and creating the local admin user for accessing the thrivecart backend.

        warden bootstrap --clean-install

 5. Load the site in your browser using the links and credentials taken from the init script output. 

    **Note:** If you are using **Firefox** and it warns you the SSL certificate is invalid/untrusted, go to Preferences -> Privacy & Security -> View Certificates (bottom of page) -> Authorities -> Import and select `~/.warden/ssl/rootca/certs/ca.cert.pem` for import, then reload the page.
    
    **Note:** If you are using **Chrome** on **Linux** and it warns you the SSL certificate is invalid/untrusted, go to Chrome Settings -> Privacy And Security -> Manage Certificates (see more) -> Authorities -> Import and select `~/.warden/ssl/rootca/certs/ca.cert.pem` for import, then reload the page.

### Additional Configuration

Information on configuring and using tools such as Xdebug, LiveReload, MFTF, and multi-domain site setups may be found in the Warden docs page on [Configuration](https://docs.warden.dev/configuration.html).

### Destroying Environment

To completely destroy the local environment we just created, run `warden env down -v` to tear down the project’s Docker containers, volumes, and (where applicable) cleanup the Mutagan sync session.
# thrivecart
