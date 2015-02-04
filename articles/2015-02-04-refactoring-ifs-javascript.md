title: "Refactoring if statements in Javascript"
author: "Jordan Lane"
---
Yesterday [Shane](https://twitter.com/webknit) came to me asking if I could think of a way to make a function shorter that he was working on for his latest [Webwork](http://webwork.webknit.co.uk/) project, which was to [make a colour clock with JS](http://webwork.webknit.co.uk/2015-02-04), like usual I was intruiged and started to think of potential solutions in my head, little did I know what I was getting myself into!

---more---

The function he was talking about was this one that, depending on the day or time would return a different status to display underneath the clock.

~~~javascript
ColorClock.checkText = function(hour, day) {

    var status;

    if(day == 6 || day == 0) {
        status = "What are you doing here? It's the weekend!"
    } else if(hour >= 12 && hour < 13) {
        status = "It's dinner time!!";
    }
    ...
    else if(hour >= 07 && hour < 19 && day != 6 && day != 0) {
        status = "Morning everyone!";
    } else if(hour >= 07 && hour < 19 && day == 1) {
        status = "Morning everyone! Hope you've had a good weekend!";
    } else {
        status = "";
    }
    console.log(status);
}

~~~

That's a slightly condensed version but that was the gist of it, a series of if statements that would return a particular status. I quickly jumped into Sublime and started on the first case, easy, I thought.

~~~javascript
var statuses = {
    weekend: 'What are you doing here? It\'s the weekend',
    default: ''
};

switch(day) {
    case 6:
    case 0:
        return statuses.weekend;
        break;
    default: 
        return statuses.default;
}
~~~

Well that's certainly a different way to approach it, whether it's easier to read or maintain is a different question. I moved on to the second case:

~~~javascript
else if(hour >= 12 && hour < 13) {
    status = "It's dinner time!!";
}
~~~

I wondered whether that could be refactored into a similar switch, and while technically it's possible, it's a bit of a hack and definitely not efficient (40 times slower than the if statements accoring to [StackOverflow](http://stackoverflow.com/a/12259830)). 

~~~javascript
switch(true) {
    case (hour >= 12 && hour < 13):
        return statuses.dinnerTime;
        break;
    default:
        return statuses.default;
}
~~~

After deciding that wasn't really an option, I instead approached the problem from the opposite side, what would I like the solution to look like? I thought that an object approach would be nice and this is what I came up with:

~~~javascript
var cases = [
    { equals: [0, 6], status: statuses.weekend },
    { lowerLimit: 12, upperLimit: 13, status: statuses.dinnerTime },
    { lowerLimit: 17, upperLimit: 23, status: statuses.homeTime }
];
~~~

This would allow me to have an arbitrary number of cases, and return the appropriate status for each. You may have noticed however that I'm comparing days in the first case and hours in the next, with no way of distinguishing the two, so I added an extra property called value which will store the type of value. 

~~~javascript
var cases = [
    { value: 'day', equals: [0, 6], status: statuses.weekend },
    { value: 'hour', lowerLimit: 12, upperLimit: 13, status: statuses.dinnerTime },
    { value: 'hour', lowerLimit: 17, upperLimit: 23, status: statuses.homeTime }
];
~~~

I then set out creating the function to handle these cases, first of all I needed to get the value that the case is relating to, this could have been done with an if like so:

~~~javascript
ColorClock.getStatus = function(currentCase) {
    var value;
    if(currentCase.value === 'day') {
        value = this.day;
    } else if(currentCase.value === 'hour') {
        value = this.hours;
    }
};
~~~

However this entire post is about refactoring if statements! So let's approach it differently.

~~~javascript
ColorClock.getTime = function() {
    ...
    this.values = {
        day: day,
        hour: hour
    };
}

ColorClock.getStatus = function(currentCase) {
    var value = this.values[currentCase.value];
};
~~~

I use the ability of accessing object values using array notation to grab the appropriate value from the values object, which means it's easy to add and remove values when necessary and also looks a bit cleaner. 

Next I needed to know which properties the current case had so that I could execute the appropriate conditions, to do this I use the `hasOwnProperty` method like so: 

~~~javascript
var hasEquals = currentCase.hasOwnProperty('equals');
var hasLower = currentCase.hasOwnProperty('lowerLimit');
var hasUpper = currentCase.hasOwnProperty('upperLimit');
~~~

With this in place, all that should be left was the easy bit of the conditions, right?

~~~javascript
ColorClock.getStatus = function(currentCase) {
    
    var value = this.values[currentCase.value];
    var hasEquals = currentCase.hasOwnProperty('equals');
    var hasLower = currentCase.hasOwnProperty('lowerLimit');
    var hasUpper = currentCase.hasOwnProperty('upperLimit');

    if(hasEquals && !hasLower && !hasUpper) {
        if(currentCase.equals.indexOf(value) !== -1) return currentCase.status;
    } else if(hasEquals && hasLower && !hasUpper) {
        if(currentCase.equals.indexOf(value) !== -1 && value >= currentCase.lowerLimit) return currentCase.status;
    } else if(hasEquals && !hasLower && hasUpper) {
        if(currentCase.equals.indexOf(value) !== -1 && value < currentCase.upperLimit) return currentCase.status;
    } else if(hasEquals && hasLower && hasUpper) {
        if(currentCase.equals.indexOf(value) !== -1 && value >= currentCase.lowerLimit && value < currentCase.upperLimit) return currentCase.status;
    } else if(!hasEquals && hasLower && !hasUpper) {
        if(value >= currentCase.lowerLimit) return currentCase.status;
    } else if(!hasEquals && !hasLower && hasUpper) {
        if(value < currentCase.upperLimit) return currentCase.status;
    } else if(!hasEquals && hasLower && hasUpper) {
        if(value >= currentCase.lowerLimit && value < currentCase.upperLimit) return currentCase.status;
    }
    return statuses.default;
};
~~~

Wrong. This is one of those situations that makes writing tests seem more useful than ever. It's not quite as scary as it looks, but it's still not pretty. It has conditions for each possibility a case could have, including having equals, lower and upper boundary, or just a singular condition like equals for example.

At this point with a loop running through all the cases and calling this function I thought I could call it a day, until I realised that the if statements at the end of the original function couldn't be replicated.

~~~javascript
} else if(hour >= 07 && hour < 19 && day == 1) {
    status = "Morning everyone! Hope you've had a good weekend!";
}
~~~

The reason being that this is comparing two different values, not something that could be done with the current setup. I decided to tackle this in the same way as the last requirement, thinking of how I wanted it to look and function, then implementing a solution.

~~~javascript
var cases = [
    { value: 'day', equals: [0, 6], status: statuses.weekend },
    { value: 'hour', lowerLimit: 12, upperLimit: 13, status: statuses.dinnerTime },
    { value: 'hour', lowerLimit: 17, upperLimit: 23, status: statuses.homeTime },
    [ 
        { value: 'hour', lowerLimit: 7, upperLimit: 19, status: statuses.goodWeekend },
        { value: 'day', equals: [1], status: statuses.goodWeekend }
    ]
];
~~~

I thought that a nice way to approach this would be a nested array, where each case in the array would have to match for it to return a status. For the solution I was trying to think of a way to keep the current `getStatus()` function the same, so I decided to add a check in the cases loop to see if the currentCase was an array or not.

~~~javascript
for (var i = cases.length - 1; i >= 0; i--) {

    // Check if current object is an array so we can handle multiple cases
    if(Object.prototype.toString.call(currentCase) === '[object Array]') {
        status = ColorClock.handleMultiCase(currentCase);
    } else {
        status = ColorClock.getStatus(currentCase);
    }

    if(status !== statuses.default) {
        // Drop out of loop because we have a match
        break;
    }
}
~~~

All that was then left to do was to add a method for handling the multi case, this was pretty simple and just involves looping through the currentCases that get passed in, and returning early if any of the conditions do not match. 

~~~javascript
ColorClock.handleMultiCase = function(currentCases) {

    for (var i = currentCases.length - 1; i >= 0; i--) {
        // Run the normal single case function
        var currentStatus = getStatus(currentCases[i]);
        // Check if it returns without a match
        if(currentStatus === statuses.default) return statuses.default;
        return currentStatus;
    };
};
~~~

There you have it! A way of refactoring a series of if statements, now whether or not this is a good solution, or even meets the brief of making the function smaller, I'm not so sure. But it was a fun challenge, and you can see it implemented on the [colour clock](http://function.webknit.co.uk/projects/colour-clock/index.html) or find more information on the [webwork challenge](http://webwork.webknit.co.uk/2015-02-04), and a special thanks to [Shane](https://twitter.com/webknit) for the challenge and credit.

Until next time!