@echo off
set /p message="Enter commit message: "
git add .
git commit -a -m "%message%"
git push
set /p cm="Enter to exit "

