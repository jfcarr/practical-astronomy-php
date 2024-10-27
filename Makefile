PHPCMD=php --php-ini=php.ini

default:
	@echo 'Targets:'
	@echo '  test             Run all tests'
	@echo '  testdatetime     Test date/time functions'
	@echo '  testcoordinates  Test coordinate functions'
	@echo '  testsun          Test sun functions'
	@echo '  testplanets      Test planet functions'
	@echo '  testcomet        Test comet functions'
	@echo '  testbinary       Test binary star functions'

test: testdatetime testcoordinates testsun testplanets testcomet testbinary

testdatetime:
	@$(PHPCMD) testDateTime.php

testcoordinates:
	@$(PHPCMD) testCoordinates.php

testsun:
	@$(PHPCMD) testSun.php

testplanets:
	@$(PHPCMD) testPlanets.php

testcomet:
	@$(PHPCMD) testComet.php

testbinary:
	@$(PHPCMD) testBinary.php