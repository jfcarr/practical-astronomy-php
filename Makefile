PHPCMD=php --php-ini=php.ini

default:
	@echo 'Targets:'
	@echo '  test             Run all tests'
	@echo '  testdatetime     Test date/time functions'
	@echo '  testcoordinates  Test coordinate functions'

test: testdatetime testcoordinates

testdatetime:
	@$(PHPCMD) testDateTime.php

testcoordinates:
	@$(PHPCMD) testCoordinates.php