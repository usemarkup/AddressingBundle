.PHONY: all
default: all;

analysis:
	vendor/bin/phpstan.phar analyse -c phpstan.neon -l 2 .

unit:
	vendor/bin/phpunit --no-coverage

all: analysis unit