.PHONY: test
test:
	php -f ./test/fixtures/ScriptFixtureLoader.php
	./vendor/bin/phpunit ./test --colors