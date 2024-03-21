PHPCMD=php --php-ini=php.ini

default:
	@echo 'Targets:'
	@echo '  test             Run all tests'
	@echo '  testdatetime     Test date/time functions'
	@echo '  testcoordinates  Test coordinate functions'
	@echo '  testsun          Test sun functions'

test: testdatetime testcoordinates testsun

testdatetime:
	@$(PHPCMD) testDateTime.php

testcoordinates:
	@$(PHPCMD) testCoordinates.php

testsun:
	@$(PHPCMD) testSun.php