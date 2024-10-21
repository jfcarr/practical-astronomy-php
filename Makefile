PHPCMD=php --php-ini=php.ini

default:
	@echo 'Targets:'
	@echo '  test             Run all tests'
	@echo '  testdatetime     Test date/time functions'
	@echo '  testcoordinates  Test coordinate functions'
	@echo '  testsun          Test sun functions'
	@echo '  testplanets      Test planet functions'

test: testdatetime testcoordinates testsun testplanets

testdatetime:
	@$(PHPCMD) testDateTime.php

testcoordinates:
	@$(PHPCMD) testCoordinates.php

testsun:
	@$(PHPCMD) testSun.php

testplanets:
	@$(PHPCMD) testPlanets.php