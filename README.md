yolo-spice
==========

Alright, if you guys are reading this, then let's hit the ground running. I propose that we finish this thing by the end of this weekend/Tuesday. Anyway, Jolly good!

I'll get done the comments page by monday, polish off the css on tuesday perhaps?

Okay, so to be clear as to how to use GitHub for this assignment, I'll leave a little bit of an instruction manual.

Step 1) Use Putty (or Terminal for MACs) to ssh to your public_html folder. (not difficult becuase you're already there once you log in)
Step 2) After you're in your assignment4.1 folder, use the command "git clone https://github.com/CS008/yolo-spice" to clone the repository into your assignment4.1 folder
Step 3) Now that you have the files in your UVM folders, go ahead and leave terminal/putty up so we can use it later.
Step 4) Okay, now you need to map a network drive. Bill, you probably can do this no problem. Adiran, I can help you. We can sit down quickly to get this done. SAVE this connection for the future.
Step 5) Now that you have the files and can easily access them via your personal file editors, we can get into the fun commands!

GITHUB COMMANDS NECESSARY TO LEARN
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want, you can write these down for quick reference, but they'll be here too. 

Command 1: git clone (URL)
		-takes the repository from the URL provided and 'copies' it to the local system.
		-only needed for the first time you get the files

Command 2: git status
		-tells you which of your files you have edited
		-if you've edited the files, you must add them. but how?

Command 3: git add (options)
		OPTIONS:
			- git add . OR git add -a 
				~ adds all files to the list
			- git add (FILENAME)
				~ adds the file to the list

Command 4: git commit -m "message"
		- so this one is pretty important and must be used after git add
		- it tells git that you are completely satisfied with the changes and that they should be recorded
		- IMPORTANT: "message" is just a holder. Inside the quotes, you must' describe the changed that are being committted. Please be mindful with the commit messages, the less vague they are; the better! :3

Command 5: git push/ git pull
		- Now you want to send the files. How?
		- git push will push the files up to github. 
		- git pull will pull the files from github.
		- each will require you to enter your username and password
			~ if either of you want, I can set up git to store your password for your session so you don't have to repeatably enter your username and password


So, that's what you need to know. Cheers!    
