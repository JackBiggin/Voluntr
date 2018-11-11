> ⚠️ This is a Hackathon entry for HackGT 5, and was created in under 36 hours. The code in this repo is likely to be hacky and potentially unstable/insecure, so please be careful if forking this repo. [You can view the project's Devpost page here.](https://devpost.com/software/voluntr-07hzfj)

# Voluntr

## Inspiration
We believe that volunteering is a great way to help your local community and gain new skills. However, we found that finding local opportunities is really difficult. To combat this, we've built a location based volunteering listing site, which has a really low barrier to entry - provided you have a LinkedIn account, you already have a Voluntr account.

## What it does
Signup is simple - we use oAuth to allow you to login via LinkedIn. You don't need to provide any further info if you don't want to - we already have your location, job title, name, email and profile picture.

Using HERE.com's API, volunteering opportunities are listed based on the distance from where the user is based, ensuring they see the opportunities that they're able to get involved with as quickly as possible. They're also shown the distance and and time it would take to get there, based on real-time traffic conditions.

Users are also able to add their own opportunities to the site, which will then be shown in the location based list.

## How I built it
Voluntr's backend is built with PHP, and a mySQL database is used to store user data, preferences and events. We used The League of Extraordinary Package's OAuth 2 Client to handle authentication, although sessions and storing user data is done using custom code.

The frontend is built using what you'd expect - HTML, CSS, Bootstrap and love.

## Challenges I ran into
> I had to learn PHP and SQL very quickly, and it was difficult. Implementing location and distance data was also very challenging and we were almost not able to implement it completely. -**Tanmay**

> Integrating with HERE.com ended up being slightly harder than I expected, especially since we were so tired when we got to that point. I also had some problems with integrating oAuth at first, as I had to learn how to use Composer, but I managed to do that pretty quickly. Only having three team members meant there was quite a lot of pressure on each of us, but I think we managed really well. -**Jack**

> I had to learn about User Interfaces (UI) and User Experiences (UX) in very little time. It was a steeper learning curve and definitely overwhelmed me a bit. It was hard to understand what makes a website look beautiful and aesthetic all the while being easy for any user to move around freely enough without being confused and think beyond what we intended. -**Raheel**

## Accomplishments that I'm proud of
> I had done little HTML and CSS in the past, and creating this website made me much better at it than I was a few days ago. I also have never worked in back end, and I was proud that I could learn and understand some parts of the back end. -**Tanmay**

> I'm really pleased with how well the oAuth works, and the HERE API integration worked really well. I'm also really pleased that we managed to finish with a somewhat complete product, despite it looking unlikely at the start of the hackathon. -**Jack**

> I have used Adobe Photoshop and Xd, but had very little knowledge of applying them towards a complete website with a nice UI. I have also never understood what UX really was until the past few days where I learned and applied about making a website more functional, and I am proud of that. -**Raheel**

## What I learned
> Bootstrap framework, PHP, SQL -**Tanmay**

> I learned how to integrate oAuth properly, using a proper framework rather than spaghetti code. I also really improved my mentoring skills. -**Jack**

> I learned that colors and other aesthetics for a website makes someone stand out, but an even better website is simple enough for even a grandma can understand and move around. -**Raheel**

## Future Improvements
While our current design is functional, it's not exactly the prettiest thing ever. Therefore, one of our team members created mockups how the site would be designed if released - [they're available to view here](https://imgur.com/a/79AogHG).

There's also a few bugs that we know need squashing, and a few display quirks, but nothing major.
