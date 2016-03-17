# Contributing to phpgeo

Note: It's a good idea to [open an issue](https://github.com/mjaschen/phpgeo/issues)
for bugs or feature proposals first.

The contribution workflow is described as follows:

1. Fork phpgeo, clone repository (`git clone git@github.com:yourname/phpgeo.git`)
2. Checkout your feature or bug-fix branch (e. g. `git checkout -b fix-random-bug`)
3. Add tests for your changes
4. Make your changes
5. Run the tests (`./vendor/bin/phpunit`)
6. Iterate through steps 3 to 5 until all tests pass.
7. Commit your changes (`git add -A -- . && git commit`)
8. Push to your fork (`git push --set-upstream origin fix-random-bug`)
9. Create a pull request from your feature or bug-fix branch to phpgeo's "develop" branch
