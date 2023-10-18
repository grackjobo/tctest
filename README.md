<center><img width="690" alt="image" src="https://github.com/grackjobo/tctest/assets/79042620/5829d296-b176-40a6-abed-40b589832543"></center>

### To Do 

- [x] Composer
- [ ] PHPUnit (Unit and integration tests)
- [x] PHPStan
- [x] Docker
- [x] Docker Compose
- [ ] Dependency Injection
- [ ] Strategy Pattern
- [x] Sensible types 
- [x] Source control and code review
- [x] Good separation/encapsulation
- [x] Small accurate interfaces


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


###Notes:

Hey andy ! I've finished (well, not really finished at all, but worked on) the code test.

In our discussion you mentioned that the lead dev was leaving, that he had been kind of a one man show and that it was pretty important to have an extensible platform that could be easily extended by developers. I considered the slim php microframework but ended up landing on laravel because of the large development community surrounding it (which should make it easier to hire new developers ) and because it includes testing with phpunit, phpstan out of the box with pretty easy command line invocation.

I leveraged the warden command line framework for container orchestration to simplify just being able to bring up an environment immediately. I also wrote a very spare number of supporting scripts in the "scripts" directory which are invoked by the "setup.sh" in the root of the project. They're meant to be run on an osx box, the cpu type (AArch64 vs x86_64) shouldn't be impacted but I'd guess that there are probably still some bumps. It checks for homebrew, installs it and installs orbstack, which is a good drop in replacement for docker, and warden. I stopped messing with system admin-y stuff there.

Once in warden (warden svc up, warden env up) it's pretty trivial to warden shell into the phpfpm container- I initialized a laravel project and a migration script for a products table in mysql, which I hydrated with the corresponding product names and metadata
Xnapper-2023-10-16-1.25.30 pm.png
I did some reading around laravel's use of the service container to manage dependency injection and created a Basket class and some very rudimentary interfaces in the correspondingly named directory. Honestly I'd like to rethink these as sort of contracts maybe in a directory that was named the same thing. Haven't used laravel a ton but I chose it rather than writing my own small framework or using slim because in the end, the problem described really pretty obviously warranted it. 

I was able to run phpstan without it being grumpy:
Xnapper-2023-10-16-1.34.42 pm.png
But unsurprisingly the phpunit tests aren't running well yet nor the API endpoints. I have some pretty fundamental debugging to do in terms of cart rules. I've got the products pretty dialed in.
Xnapper-2023-10-16-1.37.41 pm.png
I've got a  BasketService class that has an add and total method with the add method taking the product code and the total method considering the bogo or really buy one get half off rule for red and discounted shipping based on order cost ($50-90).  I'm still poking around at that and am going to check something in here in the near future. 

The repo is here: https://github.com/grackjobo/tctest

I'd love to schedule another calendly chat- I'll throw something on your calendar (hopefully! I know you're back to back much of the time). 
