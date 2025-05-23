<!-- START section1 -->
# Part 1: Creating the basics

---

## Strings, input(), and print()

### Writing text: `Strings`

In coding, we use the word string to refer to text. 

We can define strings as follows: 

> Strings are text in between quotes
> 

```python
1 "This is a string"
2 'Everything you write between quotes is a string'
```

Output:

```wibblywobbly
This is a string
Everything you write between quotes is a string
```

Quotes can be double quotes " ", like in the top example, or single quotes ' ', like in the bottom example.
<!-- SUBSECTION -->
### Asking questions: `input()`

In all programming languages there are ways to ask questions to a person, whom we usually call the  user. This is a very important feature because it allows the interaction between a computer and a  human being.

`input()` allows us to insert some text. `input()` performs a specific task and is called a built-in function.  

> A built-in function is a command that performs a specific task
> 

Built-in functions are always followed by **parentheses ().**
<!-- SUBSECTION -->
### ASCII art: `print()`

We now know how to ask a question to a user, but how do we provide them a piece of information? We use the built-in function print()

```python
1 print ("/\_/\ ") 
2 print (">^.^< ") 
3 print (" / \ ") 
4 print ("(___)__ ")
```

Output:

```
/\_/\ 
>^.^< 
 / \ 
(___)__ 
```

> `print()` displays on screen the argument we provide
> 

In this case it is a string

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Note about whitespace:

Inside a string, spaces matter. 

Spaces are characters, so a space is an element of a string and it takes its own place. 

However, spaces do not matter between code elements.

For Example both are equivalent:

```python
1 print ("This is a string") 
2 print( "This is a string" )
```

Output:
```timeywimey
This is a string
This is a string
```
Notice how there is whitespace before the String on line 2, this does not change what is printed inside the String.   

</aside>
<!-- SUBSECTION -->
### **Recap**

- The type `String` is text in between quotes
- `input()` is a built-in function to ask a user to enter a value
- `print()` is a built-in function to display a value to screen

---

Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f?showInstructions=true" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## Variables, assignment, and string concatenation

The variable names remain the same (first_name and last_name), whereas the assigned  values can be different ("Fernando" or "Guido", "Pérez" or "van Rossum"). 

We can define variables as follows:  

> A variable is a label assigned to a value
> 

In Python, variables are lowercase. When composed of multiple words, these are connected by underscore, like in first_name. 

The symbol `=` is called assignment operator. This has nothing to do with the equals we learned in math. In coding we use the symbol `=` to assign a value to a variable, and we pronounce it as is assigned.

```python
1 first_name = "Fernando" 
2 last_name = "Pérez" 
```

Notes:

1. first name is *assigned* Fernando 
2. last name is *assigned* Pérez

At line 1 we create a variable called `first_name`. To the variable `first_name` we assign the string  `"Fernando"`, which is the value. Similarly, at line 2 we create a variable called `last_name`, to which  we assign the string `"Pérez"` as a value. In general, we can assign any value to a variable.

Let’s now run the second cell:  

```python
1 print (first_name)
2 print (last_name) 
```

1. prints first_name 
2. prints last_name 

Output:

```nonsensewonsense
Fernando Pérez
```

At line 1 we print to the screen the value assigned to the variable `first_name`,  which is Fernando. At line 2 we print the value assigned to the variable `last_name`, which is Pérez.
<!-- SUBSECTION -->
**Combining what we have learnt so far**

Let’s run this code:  

```python
1 name = input ("What's your name?") 
2 favorite_food = input ("What's your favourite food?") 
3 print ("Hi! My name is " + name) 
4 print (name + "'s favorite food is " + favorite_food)
```

Output:

```tungtungtungsahur
What’s your name? Alice 
What's your favourite food? Pasta 
Hi! My name is Alice
Alice’s favourite food is Pasta
```

Line by Line

1. The name we enter in the text box will be assigned to the variable name.  
2. Similarly to the above example, what we enter in the text box will be assigned to the variable `favorite_food`.  
3. At line 3, we print out the union of the string "Hi! My name is " and the value assigned to the variable name. When dealing with strings, the symbol `+` is called a concatenation symbol, not plus! Concatenating simply means chaining together. `+` allows us to merge strings, and we can pronounce it as *concatenated with.*
<!-- SUBSECTION -->
### **Recap**

- In coding, we assign values to variables
- The symbol `=` is the assignment operator (and not the equals symbol!), and it can be pronounced *is assigned*
- The symbol `+` is the concatenation symbol when dealing with strings (and not the plus symbol), and  it can be pronounced *concatenated with.*


Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f?showInstructions=true" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>

<!-- END section1 -->
<!-- START section2 -->
# Part 2: Introduction to lists and if/else

---

## Lists and if... in... / else…

> A list is a sequence of elements separated by commas , and in between square brackets []
> 

As its name says, a list is literally a list of elements, similar to a shopping list or a to-do list. It can contain elements of various types, such as strings, numbers, etc. For now, we will consider only lists of strings.

Lets use the code below as an example,

```python
1 books = ["Learn Python", "Python for all", "Intro to Python"] 
2 print (books)
```

Output:

```
['Learn Python', 'Python for all', 'Intro to Python']
```

On line 1 there is a variable called `books`, to which we assign a sequence of elements of type `String`:  "Learn Python", "Python for all", and "Intro to Python". 

The elements are separated by commas and they are in between square brackets. A variable with this syntax is called `list`. In our code, `books` is a list of strings. 

```python
3 wanted_book = input("Hi! What book would you like to buy?")  
4 print (wanted_book)
```

Output:

```blahblah
Hi! What book would you like to buy? Learn Python
Learn Python
```

On line 3 we created a variable called `wanted_book`, which contains the user’s answer to the question: *Hi! What book would you like to buy?* Then, on line 2, we printed the value contained in the variable `wanted_book`, which in this case is *Learn Python*.

```python
5 if wanted_book in books: 
6    print ("Yes, we sell it!") 
7 else: 
8    print ("Sorry, we do not sell that book")
```

Output:

```
Yes, we sell it!
```

Here, we meet the if/else construct. Let’s learn how it works by starting from lines 5 and  6. These lines say if `wanted_book`, which is "Learn Python", is in `books`, which is ["Learn Python",  "Python for all", "Intro to Python"] (line 5), print "Yes, we sell it!" (line 6). In line 5, we check whether the value assigned to the variable `wanted_book` is one of the elements of the list `books`.  If that is the case, then we move to line 6 and print out a positive answer to the user.

If the variable `wanted_book` is not in the list books, then it will skip over line 6 to line 7 and print “Sorry, we do not sell that book”

As you can deduce from the example above, in an if/else construct, code is executed depending on  the **truthfulness of a condition**. If the condition in the if line is met, or true, we execute the underlying  code. Otherwise, if the condition in the if line is not met, or false, then we execute the code under  else. Therefore, we can define the if/else construct as follows:  

> An if/else construct checks whether a condition is true or false, and executes code accordingly:
> 
> - if the condition is met, the code under the if condition is executed;
> - if the condition is not met, the code under else is executed.
<!-- SUBSECTION -->
Let’s now focus on the syntax. An if/else construct is composed of four parts, explained below:  

1. **if condition** (line 5) contains a condition that determines code execution. It is made up of three  components: 
    1. the keyword `if`
    2. the condition itself, and 
    3. the punctuation mark colon `:`
2. **Statement** (line 6) contains the code that gets executed if the condition at line 5 is met  
3. **else** (line 7) implicitly contains the alternative to the condition on line 5. This line is always composed of the keyword `else` followed by the colon `:`
4. **Statement** (line 8) contains the code that gets executed if the condition at line 5 is not met 

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Note: `else` and its following statements are not mandatory. There are cases when we do not want to do anything if the conditions are not met.

</aside>

In coding, we can use various types of conditions, in this case, we have a **membership condition**: `wanted_book in books` (line 5),  where we check whether a variable contains one of the elements of a list. In a membership condition,  we write: 

1. variable name, 
2. `in`, and 
3. the list in which we want to find the element. 

`in` is a membership operator.

Notice that the statements under the `if` condition (line 6) and under the `else` (line 8) are always indented, which means shifted toward the right. 

> An indentation consists of 4 spaces, or 1 tab.
> 

Under an if or an else condition, we can write as many commands as we want, but they must be indented correctly to be executed.
<!-- SUBSECTION -->
### **Recap**

- Lists are a Python type that contain a sequence of elements (for example, strings) separated by commas `,` and in between square brackets `[]`
- The `if/else` construct allows us to execute code based on conditions
- The membership operator in verifies whether an element is in a list
- In Python, we use indentation for statements below if or else

---

Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f?showInstructions=true" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## List methods: .append() and .remove()

In Python, we can modify lists by adding or removing elements. Two important methods to do this are `.append()` and `.remove()`.

> A method is a built-in function for a specific variable type
> 

You can recognize that methods are functions because they are f**ollowed by round brackets**. However, a method has its own syntax, which is composed of four elements:

1. variable name, 
2. dot,  
3. method name, and 
4. round brackets.

In the round brackets, there can be an argument, such as `new_item` in this case. Different data types have different methods. For example, `.append()` can be  used for lists but not for strings.

The `.append()` method allows us to add an element to the end of a list.

```python
1 books = ["Learn Python", "Python for all", "Intro to Python"]
2 books.append("Python in depth")
3 print(books)
```

Output:

```
['Learn Python', 'Python for all', 'Intro to Python', 'Python in depth']
```

At line 2, we used `.append("Python in depth")` to add a new book to the list. `.append()` always adds the element at the end.

The `.remove()` method removes the first matching element from a list.

```python
4 books.remove("Intro to Python")
5 print(books)
```

Output:

```
['Learn Python', 'Python for all', 'Python in depth']
```

At line 4, we removed the book "Intro to Python". If the element is not found, Python will throw an error.
<!-- SUBSECTION -->
### **Recap**

- `.append()` adds an element to the end of a list.
- `.remove()` removes the first occurrence of an element.

---


Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="300" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>

<!-- SUBSECTION -->
## List methods: .index(), .pop(), and .insert()

Lets use a new list

```python
1 todays_menu = ["burger", "salad", "coke"] 
2 print (todays_menu)
```

Output:

```
['burger', 'salad', 'coke']
```

Below, we meet the new list method .index().  

```python
1 side_dish_index = todays_menu.index("salad") 
2 print (side_dish_index)
```

Output:

```
1
```

The method `.index()` looks for the element `"salad"` in the list `todays_menu` and tells us its position.  More technically, we say that `.index()` takes the argument `"salad"` and returns its index. The position of "salad" is then assigned to the variable `side_dish_index` (line 1), which we print out (line 2). 

Note that in coding, we use the two synonyms index and position interchangeably.  Why is "salad" in position 1 and not 2? This is because in Python we count elements starting from 0,  as you can see in Figure 2.1: "burger" is in position 0, "salad" in position 1, and "coke" in position 2.

![Figure 2.1. Representation of the list todays_menu: each square is a list element, and the number above is the corresponding index.](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image.png)

Figure 2.1. Representation of the list todays_menu: each square is a list element, and the number above is the corresponding index.
<!-- SUBSECTION -->
Finally, note that an element position is a number. In Python, zero, positive, and negative whole numbers are called integers, abbreviated as `int`. In our example, the variable `side_dish_index` contains  the number `1`, and it is of type integer.

```python
1 todays_menu.pop(side_dish_index) 
2 print (todays_menu)
```

Output:

```
['burger', 'coke']
```

The method `.pop()` removes the element in position `side_dish_index` from the list `todays_menu`. In  other words, `.pop()` takes `side_dish_index` as an argument and removes the element at that index,  which is `"salad"`. In the previous chapter, we saw another method that deletes an element from a  list: `.remove()`. The method `.remove()` deletes an element of a certain value, whereas `.pop()` deletes an element in a specific position.

```python
1 todays_menu.insert(side_dish_index, "fries") 
2 print (todays_menu)
```

Output:

```
['burger', 'fries', 'coke']
```

The method `.insert()` allows us to add an element at a specific index. It takes two arguments: 

1. the index where we want to insert the new element and 
2. the value of the new element. 

In this case,  we want to insert at position `side_dish_index`, which is position `1`, the string `"fries"`. Similarly, in the  previous chapter we saw another method to add an element to a list: `.append()`. The method `.append()` adds an element at the end of a list, whereas `.insert()` adds an element  in a specific position of a list.
<!-- SUBSECTION -->
### **Recap**

- The method `.index()` returns the position of an element in a list
- The method `.pop()` removes an element in a certain position from a list
- The method `.insert()` adds an element in a certain position to a list
- Indices (or positions) of elements start from 0 and increase in increments of one unit; they are of type integer

---

Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="600" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## List slicing

In Python, there is an alternative and more compact  way to change, add, and remove list elements, which you will see in the next chapter. This alternative  method is based on slicing; therefore, in this chapter, we will focus on this topic.

> Slicing means accessing list elements through their indices
> 

```python
1 cities = ["San Diego", "Prague", "Cape Town", "Tokyo", "Melbourne"]  
2 print (cities)
```

Output:

```
['San Diego', 'Prague', 'Cape Town', 'Tokyo', 'Melbourne']  
```

In this cell, there is a list called `cities` containing five strings: "San Diego", "Prague", "Cape Town",  "Tokyo", and "Melbourne" (line 1), and we print it out (line 2). 

The syntax for slicing is very easy. It consists of the list name followed by opening and closing square brackets, like this: `cities[]`. In between the square brackets,  we write the positions of the elements we want to slice. For this reason, it’s crucial to be aware of the  positions of each element within a list. In the list cities, the elements have the following positions:

![Figure 2.2. Representation of the list cities: each square is a list element, and the number above is the corresponding index.](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%201.png)

Figure 2.2. Representation of the list cities: each square is a list element, and the number above is the corresponding index.
<!-- SUBSECTION -->
### 1. Slice "Prague":

```python
1 print (cities[1]) 
```

Output:

```
'Prague'  
```

In this cell, we slice (or access) "Prague", which is in position 1, and we print it. As you can see, when we  slice one single element from a list, we write the position of the element itself in between the square  brackets. Thus, we can summarize this syntax as `list_name[element_position]`, and we can read it as list name in position element position.

Note: For simplicity, in this example and those that follow, we just print the sliced elements. However, one could assign a sliced element to a variable, like this:  

```python
1 sliced_city = cities[1] 
2 print (sliced_city) 
```

We will assign sliced list elements to variables in the following chapters. For now, let’s focus on understanding how slicing works! 
<!-- SUBSECTION -->
### 2. Slice the cities from "Prague" to "Tokyo":

```python
1 print (cities[1:4])
```

Output:

```
['Prague', 'Cape Town', 'Tokyo'] 
```

In this cell, we slice and print three consecutive elements—"Prague", "Cape Town", and "Tokyo"— that  are at positions 1, 2, and 3, respectively. In between the square brackets, we write two numbers,  separated by a colon `:`. 

The first number is the position of the first element we want to slice, and we call it start. In this case, the start is 1, which corresponds to "Prague". The second number is the  position of the last element we want to slice, to which we must add 1. We call it stop. 

The stop always follows the plus one rule, which simply says that we must add 1 to the position of the last element we want to slice. In this example, the position of the last element ("Tokyo") is 3, to which we must add  1 because of the plus one rule, so the stop is 4. 

We can summarise the syntax to slice consecutive  elements as `list_name[start:stop]`, and we can read it as list name in positions from start to stop.
<!-- SUBSECTION -->
### 3. Slice "Prague" and "Tokyo":

```python
1 print (cities[1:4:2]) 
```

Output:

```
['Prague', 'Tokyo']  
```

In this case, we want to slice and print two non-consecutive elements—"Prague" and "Tokyo"— which  are at positions 1 and 3, respectively. In the code above, you might recognize that 1 is the start, 4 is  the stop (because of the plus-one rule), and 2? That is the step. 

As you can see, "Tokyo" is positioned 2 steps after "Prague": there is 1 step from "Prague" to "Cape Town", and 1 step from "Cape Town" to  "Tokyo", for a total of 2 steps. Therefore, the syntax to slice non-consecutive elements is an extension  of the rule we saw in the example above: `list_name[start:stop:step]`, which you can read as list  name from start to stop with step. We can call it the three-s rule, where the three s’s are the initials of  start, stop, and step, respectively. 

The most convenient aspect of the three-s rule is that we can simplify it in several situations. For example, you might wonder: why didn’t we write the step in the example 2, where we sliced the cities  from "Prague" to "Tokyo"? Because when elements are consecutive, the step is 1—"Cape Town" is 1  step after "Prague", and "Tokyo" is 1 step after "Cape Town"—and when the step is 1 we can simply omit it. Obviously, we could have written the code specifying the step as follows: 

```python
 1 print (cities[1:4:1]) 
```

Output: 

```
['Prague', 'Cape Town', 'Tokyo']  
```

However, adding the step here is a redundancy, so we simply avoid it. 
<!-- SUBSECTION -->
### 4. Slice the cities from "San Diego" to "Cape Town":

```python
1 print (cities[0:3]) 
```

Output:

```
['San Diego', 'Prague', 'Cape Town'] 
```

Here we have to slice consecutive elements. So, we specify the start, which is 0 for "San Diego", and  the stop, which is 3 for "Cape Town", but we can omit the step because it is 1. Interestingly, in this case  we can simplify the three-s rule even more! Because the start coincides with the first element of the  list, we can simply omit it:  [

```python
1 print (cities[:3]) 
```

Output:

```
['San Diego', 'Prague', 'Cape Town']
```
<!-- SUBSECTION -->
### 5. Slice the cities from "Cape Town" to "Melbourne":

```python
1 print (cities[2:5])
```

Output:

```
['Cape Town', 'Tokyo', 'Melbourne'] 
```

Again, we have to slice consecutive elements. Therefore, we specify the start, which is 2 for "Cape  Town", and the stop, which is 5 (because of the plus-one rule) for "Melbourne", but we omit the step  because it is 1. And once more, we can simplify the three-s-rule. The stop coincides with the last element of the list, so we can just omit it:

```python
1 print (cities[2:]) 
```

Output:

```
['Cape Town', 'Tokyo', 'Melbourne']
```

So far, we have seen the three-s rule applied in its entirety (example 3), and without start (example  4), stop (example 5), and step (example 2). How else can we simplify it? Let’s look at the following  example. How do you think the code will look? 
<!-- SUBSECTION -->
### 6. Slice "San Diego", "Cape Town", and "Melbourne":

```python
1 print (cities[0:5:2]) 
```

Output:

```
['San Diego', 'Cape Town', 'Melbourne']
```

This time, the elements to slice are not consecutive. We start at 0, which is the position of "San Diego",  we stop at 5 (because of the plus-one rule) for "Melbourne", and we specify the step, which is 2, because we are slicing every second element. However, as you might have guessed, because the start  coincides with the beginning of the list, and the stop coincides with the last element of the list, we can  omit both, and rewrite the code above as follows: 

```python
1 print (cities[::2]) 
```

Output:

```
['San Diego', 'Cape Town', 'Melbourne']  
```

You have now mastered the three-s rule and learned how to simplify it. How else can we play with it?  Let’s look at this further representation of the list cities:

![Figure 2.3. In a list, indices can be positive (from left to right) or negative (from right to left).](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%202.png)

Figure 2.3. In a list, indices can be positive (from left to right) or negative (from right to left).

In Python, each element of a list can be identified by a positive or a negative index. We use positive indices when we consider elements from left to right and negative indices when we consider elements  from right to left. Positive indices start from 0 and increase of 1 unit (0, 1, 2, etc.). Negative indices  start from -1 and decrease of 1 unit (-1, -2, -3, etc.). Note that negative indices do not start from 0 to  avoid ambiguity: the element in position 0 is always the first element of the list starting from the left  side. When are negative indices convenient? For example, when we are dealing with a very long list.  In that case, it would be tedious to count through all elements starting from 0. So we can just count  backwards starting from the last element.

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="600" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
### 7. Slice "Melbourne":

```python
1 print (cities[4]) 
```

Output:

```
Melbourne 
```

In this example, we extracted "Melbourne" as we learned in example 1: by writing its positive index, which is 4, in between the square brackets. However, "Melbourne" is the last element of the list; therefore, it is much more convenient to use its negative index to slice it, like this: 

```python
1 print (cities[-1]) 
```

Output:

```
Melbourne  
```

The advantage of using the negative index is that we do not need to count through all the list elements  to get to know the position of "Melbourne". Since "Melbourne" is the last element of the list, we can  just write -1. This saves us time and eliminates possible errors due to miscounting.
<!-- SUBSECTION -->
### 8. Slice all the cities from "Prague" to "Tokyo" using negative indices:

```python
1 print (cities[-4:-1]) 
```

Output:

```
['Prague', 'Cape Town', 'Tokyo']
```

This is in an alternative to example 2. There, we extracted the cities from "Prague" to "Tokyo" using  positive indices, whereas here we want to use negative indices. It might look intimidating, but the  reasoning is always the same. The first element we want to extract is Prague, which is in position -4,  therefore the start is -4. The last element we want to extract is Tokyo, which is in position -2, thus the  stop is -1 because of the plus one rule. Like in the previous example, using negative indices can be very  convenient when extracting elements from the end of a long list.  In this example, we saw how to use negative indices for the start and the stop. A negative step allows us to slice elements in reverse order, which means from the right to the left.  Negative steps can be used with both positive or negative start and stop. This might sound confusing,  but we’ll clarify it the next three examples. Slicing in reverse order is is a very powerful feature, and  it’s the last thing you need to know to master slicing. 
<!-- SUBSECTION -->
### 9. Slice all the cities from "Tokyo" to "Prague" using positive indices (reverse order):

```python
1 print (cities[3:0:-1])
```

 Output:

```
['Tokyo', 'Cape Town', 'Prague']
```

When slicing—and coding, in general—it is extremely important to be aware of the result we expect.  When slicing in reverse order, having the result in mind can really avoid confusion. So, let’s start from  there. We want to print out "Tokyo", "Cape Town", and "Prague". The first element is "Tokyo", which  is in position 3, so the start is 3. The last element is "Prague", which is in position 1. When we slice  in reverse order, instead of the plus-one rule, we have to use the minus one rule, which says that we  must subtract 1 from the position of the last element we want to slice. Why? This is very intuitive.  As we know, for the stop, we always want to take the next position. When slicing in direct order, the  next position is on the right side of the last element. Therefore, we add 1 to its index. On the other side,  when slicing in reverse order, the next position is on the left side of the last element. Therefore, we  subtract 1 from its index. Now, back to our example. The last element is "Prague", which is in position  1. And because of the minus one rule, the stop is 0. Finally, we need to define the step. Because the  elements are consecutive, the step should be 1, but because we are going in reverse order, we have  to put a minus in front of it, so the step becomes -1.  

In summary, when slicing in reverse order, we have to: 

1. make sure we have the first and the last  elements clearly in our minds, 
2. apply the minus one rule to the stop, and 
3. use a negative step
<!-- SUBSECTION -->
### 10. Slice all the cities from "Tokyo" to "Prague" using negative indices (reverse order):

```python
1 print (cities[-2:-5:-1])
```

Output:

```
['Tokyo', 'Cape Town', 'Prague']
```

When using negative indices for the start and the stop, the rules are exactly the same as when using  positive indices. The first element we want to slice is "Tokyo", which is in position -2, so the start is  -2. The last element is "Prague", which is in position -4. Because of the minus one rule, we have to  subtract 1 from -4, therefore the stop is -5. And finally, because we are slicing consecutive elements  in reverse order, the step is -1. As you can now imagine, using negative indices can be very convenient  when slicing elements at the end of a very long list in reverse order.
<!-- SUBSECTION -->
### Slice all the cities (in reverse order):

```python
1 print (cities[::-1]) 
```

Output:

```
['Melbourne','Tokyo', 'Cape Town', 'Prague', 'San Diego'] 
```

The first element to slice is "Melbourne", which is the last element of the list. Therefore, we can omit  the start. The last element to slices is "San Diego", which is the first element of the list. Therefore,  we can omit the stop too. We just must write the step, which is -1 because we are slicing consecutive  elements in reverse order. 

---
<!-- SUBSECTION -->
## Changing, adding, and removing list elements using slicing

> Slicing allows not only to extract elements from a list, but also to replace, add, or remove elements.
> 

Let's go step-by-step with examples.

### **Replacing elements through slicing**

Suppose we have this list:

```python
1 senses = ["sight", "hearing", "taste", "smell", "touch"]
2 print(senses)

```

Output:

```
['sight', 'hearing', 'taste', 'smell', 'touch']

```

Now, let's say we want to replace `"taste"` and `"smell"` with `"intuition"`. We use slicing to do it:

```python
3 senses[2:4] = ["intuition"]
4 print(senses)
```

Output:

```
['sight', 'hearing', 'intuition', 'touch']
```

**Explanation:**

At line 3, `senses[2:4]` slices `"taste"` and `"smell"`.

We replace them with the new single item `"intuition"`.

The slicing syntax `[start:stop]` works exactly like when slicing for reading, but here it’s used for **replacement**.
<!-- SUBSECTION -->
### **Adding elements through slicing**

You can **add** elements using slicing too.

Suppose we want to add `"equilibrium"` after `"intuition"`:

```python
5 senses[3:3] = ["equilibrium"]
6 print(senses)

```

Output:

```
['sight', 'hearing', 'intuition', 'equilibrium', 'touch']

```

**Explanation:**

At line 5, the slice `[3:3]` means **"at position 3, without removing anything"**.

It simply **inserts** `"equilibrium"` at that position.

> Note:
> 
> 
> When start and stop indices are the same, slicing behaves like an *insertion point*.
> 
<!-- SUBSECTION -->
### **Removing elements through slicing**

You can **remove** elements simply by assigning an empty list `[]` to a slice.

Suppose we want to remove `"equilibrium"`:

```python
7 senses[3:4] = []
8 print(senses)

```

Output:

```
['sight', 'hearing', 'intuition', 'touch']

```

**Explanation:**

We slice `[3:4]` (which selects `"equilibrium"`) and assign `[]`.

Result: `"equilibrium"` is gone.

> Side tip:
> 
> 
> This is faster and cleaner than using `.remove()` if you know the index range!
> 

---
<!-- SUBSECTION -->
### **Using `del` to remove elements**

Another way to delete elements is using the `del` keyword.

Let's remove `"intuition"`:

```python
9 del senses[2]
10 print(senses)

```

Output:

```
['sight', 'hearing', 'touch']

```

**Explanation:**

At line 9, `del senses[2]` removes the element at position 2, which is `"intuition"`.

> Important:
> 
> 
> `del` deletes the **element itself** — not just clears its value.
> 

---
<!-- SUBSECTION -->
## Deleting variables vs deleting content

It’s crucial to distinguish between **deleting the content** inside a variable and **deleting the variable itself**.

- When you slice and assign `[]`, you **delete content** (the list stays, but has different elements).
- When you use `del variable_name`, you **delete the entire variable** from memory.

Example:

```python
11 del senses
```

At this point, trying to run:

```python
print(senses)
```

would cause an error:

```
NameError: name 'senses' is not defined
```

**Explanation:**

After using `del senses`, the variable no longer exists.

---
<!-- SUBSECTION -->
Recap

- You can **replace** list elements by assigning to a slice.
- You can **add** elements at a specific position by slicing with `[index:index]`.
- You can **remove** elements by slicing and assigning `[]`, or using `del`.
- `del` deletes an element or a whole variable depending on how you use it.

Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- END section2 -->
<!-- START section3 -->
# Part 3. Introduction to the for loop

---

## for... in range()

The for loop allows us to repeatedly execute commands.

> A for loop is the repetition of a group of commands for a determined number of times.

It consists of five  components:  

- `for`: The keyword starting a for loop. Like all keywords, it is bold green in Jupyter Notebook.
- index: A variable that is assigned a different value at each loop iteration
- `in`: A membership operator, the same that you learned in the construct if...in/else in Chapter 3
- `range()`: A built-in Python function. You can recognise this as a function because it is followed by round brackets —like input() and print().
- `:` that is, the colon punctuation.

Lets look at the following code:

```python
1 friends = ["Geetha", "Luca", "Daisy", "Juhan"]
2 dishes = ["sushi", "burgers", "tacos", "pizza"]
```

```python
1 for index in range (0,4): 
2     print("index:" + str(index)) 
3     print("friend:" + friends[index])
```

This reads; for index in range from zero to four, print index: concatenated with string of index, print friend: concatenated with friends in position index.

Output:

```Blahblah
index: 0 
friend: Geetha 
index: 1 
friend: Luca 
index: 2 
friend: Daisy 
index: 3 
friend: Juhan
```

The code prints the position and the value of each list element by repeating lines 2 and 3 four times.

To better understand what this line does, let’s begin from the built-in function `range()`. It takes two  arguments: 0 and 4. They are two integers that we can call start and stop.

```python
1 list(range (0,4))
```

Output:

```
[0,1,2,3]  
```

The built-in function `range()` returns a sequence of integers spanning from the start (included) to the stop (excluded because of the plus one rule).

The list of integers created by range() are assigned the variable index. At each code repetition—or loop, or iteration—index is subsequently assigned a number created by `range()`. That is, in the first loop, index is assigned 0; in the second loop, index is assigned 1; and so  on. We could call the variable index any name—for example, `loop_id`, `iteration_number`. However, it is  convention to call it index, so we will adopt it. 

Now, what can we do with the variable index? At least  two things!  First, we can print index to keep track of which loop is getting executed, like we do at line 2. In the first loop, index is assigned 0, so we print "index: 0". In the second loop, index is assigned 1,  so we print "index: 1"—and so on. 

Why is `str()` here? Because we can concatenate only strings with strings, and index is an integer. So, we need to change the variable type of index from integer to string. And to do that, we can use the built-in function `str()`, which transforms a variable into a string.  Second, we can use index to automatically slice list elements one by one. As you now know, index changes at every iteration, and it can be assigned values that go from the beginning of a list—that  is, 0—to the end of a list—in this case 3. Let’s look at line 3 of the cell above. In the first loop, when  index is assigned 0, `friends[index]` is the same as `friends[0]`—that is, `"Geetha"`. In the second loop,  when index is assigned 1, `friends[index]` is the same as `friends[1]`, i.e., `"Luca"`. And so on.

The lines below the header—in this example, lines 2 and 3—are called the body of the for loop. They  are always indented, and there can be as many as we want. They get executed for a number of times  determined by the sequence of numbers created by the function `range()`.

A for loop:

1. Executes the lines of code that are in the body of the for loop several times
2. The number of times is known and is determined by a sequence of numbers created by the  built-in function `range()`
<!-- SUBSECTION -->
### **Recap**

- A for loop is the repetition of commands for a defined number of times
- When the for loop is used to slice a list, the number of times coincides with the list length
- The generic syntax of a for loop header is: `for index in range(start, stop, step):`
- The body of a for loop is indented and can contain as many lines of code as needed
- `range()` is a built-in Python function that creates a sequence of integers spanning from the start (included) to the stop (excluded)
- `str()` is a built-in Python function that converts a variable into a string

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## For loop with if... ==... / else…

We can combine for loops and if/else constructs.

```python
1 animals = ["giraffe", "penguin", "dolphin"] 
2 print (animals)
```

Output:

```
['giraffe', 'penguin', 'dolphin']
```

```python
1 # for each position in the list for each position in the list 
2 for i in range (0, len(animals)): 
3     print ("--- Beginning of loop ---") 
4     # print each element and its position 
5     print ("The element in position " + str(i) + " is " + animals[i])  
```

The above code reads: for `i` in range from zero to `len` of `animals`, print beginning of loop, print each element and its position print the element in position concatenated with string of `i` concatenated with is concatenated with `animals` in position `i` .

Output:

```
—-Beginning of loop ---
The element in position 0 is giraffe 
--- Beginning of loop ---
The element in position 1 is penguin 
--- Beginning of loop ---
The element in position 2 is dolphin
```

We run the for loop three times, and each time we print out the lines 3 and 5. 

The header of the for loop at line 2 contains two changes from the syntax we saw  in the previous chapter. 

1. First, we use the abbreviation `i` for the variable index. Shortening names of  frequently used variables is common in coding because it reduces the amount of typing required. Some abbreviations become conventions—like in this case—so, from this point on we will use `i`. 
2. Second,  instead of an integer, we use `len(animals)` as the stop in the built-in function `range()`. If we used an integer, then the stop would be 3, because the last element—"dolphin"—is in position 2, to which  we add 1 for the plus one rule. But what if we added another element to the list? We would have  to remember to modify the stop from 3 to 4. As you can imagine, this practice is very prone to error, as it’s easy to forget to update the stop or miscount the last element position. Therefore, we do not  want to hard-code the stop—that is, to explicitly write its value. We want to make it dependent on  the variable we are dealing with so that we do not have to take care of possible variations. To do so,  we use `len()`, **which is a built-in function that returns the length of a variable**—that is, 3 for the list `animals`. We can use this trick because the length of a list is always one unit more than the index of the last element; therefore, it coincides with the stop. From this point on, we will not need to count  to find the stop—`len()` will do it for us.

Let’s analyze the body of the for loop. At line 3, we print a string stating that we are at the beginning of a loop. It is meant to be visually different to make the printouts of each iteration easy to identify.  Beyond *Beginning of loop*, we could use sentences like New iteration, New loop, etc. To increase the  visibility, we can also use symbols before and/or after the text—such as dashes (---) in this example. Alternatives can be arrows (-->), tildes (~~~), or any other character on the keyboard. 

At line 5, we  print out each element and its position in a sentence composed of four parts concatenated to each other. The first and the third parts—"The element in position " and " is "—are two hard-coded  strings. The second element is the index of the current loop. It’s an integer, so we use the built-in function `str()` to convert it into a string. Finally, the last element (`animals[i]`) is a string, containing a list element sliced in a different position `i` at each iteration—that is, "giraffe", "penguin", or "dolphin".  Finally, lines 1 and 4 start with the hash symbol (`#`) and are followed by text. These lines are called comments.
<!-- SUBSECTION -->
### **Comments**
> Comments are code descriptions or explanations.
> 

They can contain descriptions of the code, or  explanations about why we made a certain coding choice, or any other information that is relevant  to understand the code they refer to. Comments are written for human beings not Python. 

```python
1 wanted_to_see = "penguin”
```

Assigns “penguin” to wanted_to_see

```python
1 # for each position in the list for each position in the list 
2 for i in range (0, len(animals)):
3     # if the current animal is what you really wanted to see
4     if animals[i] == wanted_to_see:
5        # print out that that's the animal you really wanted to see 
6        print ("I saw a " + animals[i] + " and I really wanted to see it!")
7     else:
8        # just print out that you saw it
9        print ("I saw a " + animals[i])
```

Output:

```
I saw a giraffe 
I saw a penguin and I really wanted to see it! 
I saw a dolphin
```

Once more, we use the for loop to browse the list elements. But this time, we apply a condition to each element. Let’s analyse line by line. 

The header of the for loop is the same as the one above. Then, at line 4, we start an if/else construct. It is similar to the one we learned in previously: it’s  composed of an if condition (line 4), a statement (line 6), an else (line 7), and another statement (line  9). However, the condition after the keyword if is different. We check if the values assigned to two variables `animals[i]` and `wanted_to_see` are equal. To do so, we write 

1. the keyword if; 
2. the  first variable, that is, `animals[i]`; 
3.  the comparison operator `==`, and
4.  the second variable, that is,  `wanted_to_see`. 

The comparison operator `==` is pronounced equals or is equal to. 

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Note that `==` is very  different from `=`. The symbol `==` is a comparison operator and is used in conditions to check if the  values assigned to two variables are the same. The symbol `=` is the assignment operator, and it is used  to assign a value to a variable.

</aside>

To make sure that what this code does is clear, let’s go through the for loop step-by-step: 

- In the first loop: at line 2, `i` is assigned `0`. At line 4, we check if `animals` in position `i`—where i is 0,  so `animals[0]` is "giraffe"—is equal to the value assigned to the variable `wanted_to_see`, which is  "penguin". Because "giraffe" is not equal to "penguin", we skip the statement under the if at line 6, and we jump directly to the statement under the `else`, which is at line 9. There, we print "I saw  a giraffe”
- In the second loop: at line 2, `i` is assigned 1. At line 4, we check again if animals in position `i`—where  i is 1, so `animals[1]` is "penguin"—is equal to the value assigned to the variable `wanted_to_see`. In this case, the values of the two variables `animals[i]` and `wanted_to_see` are  equal, so we execute the statement under the if condition (line 6), where we print "I saw a penguin  and I really wanted to see it!"
- Finally, in the third loop: at line 2, `i` is assigned 2. At line 4, we check once more if animals in position `i`—where i is 2, thus `animals[2]` is "dolphin"—is equal to the value assigned to the variable `wanted_to_see`, which is "penguin". Because "dolphin" is not equal to "penguin", we skip the statement at line 6, and we jump directly to the statement under the `else`, which is at line 9. There, we  print "I saw a dolphin”
<!-- SUBSECTION -->
### **Recap**

- In a for loop, the variable index is commonly abbreviated with `i`
- The built-in function `len()` returns the length of a variable
- We can use the if/else construct in a for loop
- We can use the comparison operator `==` (equals or is equal to) in an if condition
- Comments start with the hash symbol `#`, and they are descriptions or explanations

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## Other uses for For loops

### **Searching a list**

We can use a for loop combined with an if/else construct to search for elements in a list. It is good practice to create variables instead of hard-coded values in a block of code to reduce the  possibility of errors. Variables are usually located at the beginning of a block of code. In Python, there are six comparison operators: 

| Operator | Name | Example |
| --- | --- | --- |
| == | Equal | x == y |
| != | Not equal | x != y |
| > | Greater than | x > y |
| < | Less than | x < y |
| >= | Greater than or equal to | x >= y |
| <= | Less than or equal to | x <= y |

### **Change list elements**

To change list elements, we always need to reassign the changed element to itself. such as

```python
emails[i] = emails[i].lower()
```

Python has at least four methods to change character cases: 

- `.lower()` to change all characters of a string to lowercase
- `.upper()` to change all characters of a string to uppercase
- `.title()` to change the first character of a string to uppercase and all the remaining characters to  lowercase
- `.capitalize()` to change the first character of each word in a string to uppercase, and all the remaining characters to lowercase

### **Create new lists**

As a general rule, when using a for loop to create and fill an empty list, we have to:

1. Initialise an empty list before the for loop 
2. Concatenate or append new elements within the for loop

```python
# initialize the variables as empty lists 
2 shelf_a = []  
3 shelf_s = [] 
4  
5 # for each position in the list for each position in the list 
6 for i in range (len(authors)):
7  
8     # print out the current element
9     print ("The current author is: " + authors[i])  
10 
11    # get the initial of the current author
12    author_initial = authors[i][0] 
13    print ("The author's initial is: " + author_initial)
14 
15    # if the author's initial is A
16    if author_initial == "A": 
17       # add the author to the shelf a
18       shelf_a.append(authors[i])
19       print ("The shelf A now contains: " + str(shelf_a) + "\n")
20 
21    # otherwise (author's initial is not A) otherwise (author's initial is not A) 
22    else:
23       # add the author to the shelf s
24       shelf_s = shelf_s + [authors[i]]
25       print ("The shelf S now contains: " + str(shelf_s) + "\n")
26  
27 # print out the final shelves
28 print ("The authors on the shelf A are: " + str(shelf_a)
29 print ("The authors on the shelf S are: " + str(shelf_s)
```

Output:

```
The current author is: Alcott 
The author's initial is: A 
The shelf A now contains: ['Alcott']

The current author is: Saint-Exupéry 
The author's initial is: S 
The shelf S now contains: ['Saint-Exupéry']  

The current author is: Arendt 
The author's initial is: A 
The shelf A now contains: ['Alcott', 'Arendt']  

The current author is: Sepulveda 
The author's initial is: S 
The shelf S now contains: ['Saint-Exupéry', 'Sepulveda']  

The current author is: Shakespeare 
The author's initial is: S 
The shelf S now contains: ['Saint-Exupéry', 'Sepulveda', 'Shakespeare']  

The authors on the shelf A are: ['Alcott', 'Arendt'] 
The authors on the shelf S are: ['Saint-Exupéry', 'Sepulveda', 'Shakespeare']
```

String slicing works the same way as list slicing. In multiple consecutive slicings, we execute one slicing at a time, starting from the left.

The special character "\n" creates an empty line after a print
---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- END section3 -->
<!-- START section4 -->
# Part 4. Numbers and algorithms

---

## Integers, floats, and arithmetic operations

> In coding, we often manipulate numbers.
> 
> 
> Let’s learn how to work with numbers in Python, starting by building a simple calculator.
> 

### **Arithmetic operators**

Python can perform all basic arithmetic operations using specific operators:

| Operation | Symbol | Example | Result |
| --- | --- | --- | --- |
| Addition | `+` | `5 + 3` | 8 |
| Subtraction | `-` | `5 - 3` | 2 |
| Multiplication | `*` | `5 * 3` | 15 |
| Division | `/` | `5 / 3` | 1.666... |

Let's try them with actual code:

```python
1 print(5 + 3)
2 print(5 - 3)
3 print(5 * 3)
4 print(5 / 3)

```

Output:

```
8
2
15
1.6666666666666667

```

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Note:

In Python, division always returns a float (even if it’s a whole number result).

</aside>

<!-- SUBSECTION -->

### **Asking for numbers as input**

Suppose we want to ask a user for two numbers and perform operations on them.

Using `input()`:

```python
1 first_number = input("Enter your first number: ")
2 second_number = input("Enter your second number: ")
3 print(first_number)
4 print(second_number)

```

Example Output:

```
Enter your first number: 5
Enter your second number: 3
5
3

```

**Explanation:**

- `first_number` and `second_number` are **strings** right now, because `input()` always gives a string by default.
<!-- SUBSECTION -->
### **Converting strings to numbers: `int()` and `float()`**

To perform calculations, we need to **convert the input strings into numbers**.

```python
5 first_number = int(first_number)
6 second_number = int(second_number)

```

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Side Note:

Use `int()` if you expect whole numbers (e.g., 5, 10, 100).

Use `float()` if you expect decimals (e.g., 3.14, 2.5).

</aside>

Example with `float()`:

```python
5 first_number = float(first_number)
6 second_number = float(second_number)

```

**Building the calculator**

Now let's put it all together:

```python
1 first_number = input("Enter your first number: ")
2 second_number = input("Enter your second number: ")
3 operation = input("Choose an operation (+, -, *, /): ")

4 first_number = float(first_number)
5 second_number = float(second_number)

6 if operation == "+":
7     print(first_number + second_number)
8 elif operation == "-":
9     print(first_number - second_number)
10 elif operation == "*":
11     print(first_number * second_number)
12 elif operation == "/":
13     print(first_number / second_number)
14 else:
15     print("Operation not supported.")

```

Example Run:

```
Enter your first number: 7
Enter your second number: 2
Choose an operation (+, -, *, /): *
14.0

```
---
Have a play with this calculator code!

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
### **Understanding the `elif` keyword**

In the calculator code, you saw something new: `elif`.

> elif means "else if".
> 
> 
> It allows checking **multiple conditions one after another**.
> 

It’s like saying:

- If the first condition is true, do that.
- Else if the second condition is true, do that.
- Else if the third condition is true, do that.
- Otherwise (else), do something else.

Without `elif`, you would have to nest lots of if/else statements, which would be messy.
<!-- SUBSECTION -->
### **Checking the type of a variable: `type()`**

Python lets us check what type a variable is:

```python
1 print(type(first_number))

```

Output:

```
<class 'float'>

```

**Explanation:**

- After using `float()`, the variable is now a **float**.
- If we had used `int()`, it would show as **int**.

<aside>
<img src="https://www.notion.so/icons/flag_gray.svg" alt="https://www.notion.so/icons/flag_gray.svg" width="40px" />

Helpful Tip:

Always know whether you are working with strings, ints, or floats when coding math!

</aside>
<!-- SUBSECTION -->

### **Recap**

- `+`, , , `/` are Python’s arithmetic operators.
- `input()` returns a string — use `int()` or `float()` to turn it into a number.
- `if/elif/else` structures allow you to make multi-branch decisions.
- `type()` checks the data type of a variable.

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->

## Common Operations with Lists of Numbers

In this chapter, we will explore typical tasks performed with lists of numbers.

### **Changing Numbers Based on Conditions**

One common task is changing numbers in a list based on certain conditions.

**Example:**

```python
1 numbers = [12, 3, 15, 7, 18]  # List of numbers
```

**Task:** Subtract 1 from numbers greater than or equal to 10, and add 2 to numbers less than 10.

```python
2 for i in range(len(numbers)):  # For each position in the list
3     if numbers[i] >= 10:  # If current number is >= 10
4         numbers[i] = numbers[i] - 1  # Subtract 1
5     else:  # Otherwise
6         numbers[i] = numbers[i] + 2  # Add 2
7 print(numbers)  # Print the final result

```

**Output:**

```
[11, 5, 14, 9, 17]
```

In this example, we loop through each number in the list. If the number is greater than or equal to 10, we subtract 1; otherwise, we add 2.

<!-- SUBSECTION -->
### **Separating Numbers Based on Conditions**

Another common task is to separate numbers into new lists based on conditions.

**Example:**

```python
1 numbers = [2, 10, 7, 5, 0, 9]  # List of numbers

```

**Task:** Separate the numbers into two lists—one for even numbers and one for odd numbers.

```python
2 even = []  # Initialize empty list for even numbers
3 odd = []  # Initialize empty list for odd numbers
4 for i in range(len(numbers)):  # For each position in the list
5     if numbers[i] % 2 == 0:  # If current number is even
6         even.append(numbers[i])  # Add to even list
7     else:  # Otherwise
8         odd.append(numbers[i])  # Add to odd list
9 print(even)  # Print even numbers
10 print(odd)  # Print odd numbers

```

**Output:**

```
[2, 10, 0]
[7, 5, 9]

```

Here, we create two empty lists and loop through the numbers. We check if each number is even or odd and append it to the respective list.

<!-- SUBSECTION -->
### **Finding the Maximum of a List of Numbers**

A common task is to find the maximum number in a list.

**Example:**

```python
1 numbers = [2, -5, 34, 70, 22]  # List of numbers

```

**Task:** Find the maximum number.

```python
2 maximum = numbers[0]  # Initialize maximum with the first element
3 for i in range(1, len(numbers)):  # For each position starting from the second
4     if numbers[i] > maximum:  # If current number is greater than maximum
5         maximum = numbers[i]  # Assign current number to maximum
6 print(maximum)  # Print the maximum

```

**Output:**

```
70
```

We initialize the maximum with the first number and loop through the rest, updating the maximum whenever we find a larger number.
<!-- SUBSECTION -->
### **Recap**

When dealing with lists of numbers, some of the basic tasks are: 

- Changing numbers in a list depending on conditions
- Separating numbers into new lists based on conditions
- Finding the maximum (or minimum) number in a list

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## **The Python Module `random`**

In this chapter, we will learn how to generate random numbers using the **`random`** module. Randomness is useful in coding for games, simulations, and more.

> A module is a unit containing functions for a specific task
> 

### **Fortune Cookies**

You are at a Chinese restaurant, and at the end of the meal, you get a fortune cookie. There are three fortune cookies left, each containing a message:

```python
1 fortune_cookies = [
2     "The man on the top of the mountain did not fall there",
3     "If winter comes, can spring be far behind?",
4     "Land is always on the mind of a flying bird"
5 ]
```

### **Picking a Fortune Cookie**

To let the computer decide which fortune cookie you get, we need to use the **`random`** module:

```python
1 import random # Import the random module

```

### **Select a Random Message Index**

We can pick a random index for the fortune cookie:

```python
1 message_index = random.randint(0, len(fortune_cookies) - 1)  # Pick a random index
2 print(message_index)  # Print the index
```

The function **`randint(a, b)`** returns a random integer between **`a`** and **`b`**, inclusive.

### **Get the Message**

Now, we can get the message from the fortune cookie:

```python
1 message = fortune_cookies[message_index] # Get the message
2 print(message) # Print the message

```

### **Using `random.choice()`**

Alternatively, we can use **`random.choice()`** to directly pick a random message:

```python
1 message = random.choice(fortune_cookies) # Pick a random message
2 print(message) # Print the message
```
<!-- SUBSECTION -->
### **Recap**

- A module is a unit containing functions for a specific task.
- To import a module, we use the keyword **`import`**.
- When calling a module function, we use the syntax: **`module_name.function_name()`**.
- The **`random`** module generates random numbers and includes functions like:
    - **`.randint(a, b)`**: returns a random integer between **`a`** and **`b`** (inclusive).
    - **`.choice(list_name)`**: returns a random element from a list.

---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- SUBSECTION -->
## Introduction to programs

In this chapter, we will learn how to implement a simple game of Rock Paper Scissors using Python. This game involves two players, where each player simultaneously chooses one of three options: rock, paper, or scissors.

### **Game Rules**

The rules of the game are straightforward:

- Rock crushes scissors.
- Scissors cuts paper.
- Paper covers rock.

The winner is determined based on these rules.

### **Getting User Input**

We will ask the user to choose between rock, paper, or scissors. We can use the `input()` function to gather this information.

```python
1 player_choice = input("Choose rock, paper, or scissors: ").lower()  # Get user input and convert to lowercase

```

### **Generating the Computer's Choice**

To make the game more interesting, we will also have the computer make a random choice. We can use the `random` module to achieve this.

```python
2 import random  # Import the random module
3 options = ["rock", "paper", "scissors"]  # List of options
4 computer_choice = random.choice(options)  # Randomly select an option for the computer

```

### **Determining the Winner**

After both the player and the computer have made their choices, we will compare them to determine the winner.

```python
5 if player_choice == computer_choice:
6     print("It's a tie!")
7 elif (player_choice == "rock" and computer_choice == "scissors") or \\
8      (player_choice == "scissors" and computer_choice == "paper") or \\
9      (player_choice == "paper" and computer_choice == "rock"):
10     print("You win!")
11 else:
12     print("You lose!")

```

### **Game Loop**

To make the game more engaging, we can implement a loop that allows the player to play multiple rounds until they decide to stop.

```python
13 while True:
14     # Get user input and computer choice
15     # Determine the winner
16     play_again = input("Do you want to play again? (yes/no): ").lower()
17     if play_again != "yes":
18         break  # Exit the loop if the player does not want to continue

```
<!-- SUBSECTION -->
### **Debugging**

> Debugging means identifying and removing errors from code.
> 

Debugging is the process of identifying and fixing errors in the code. Common errors include:

- **Syntax Errors:** Mistakes in the code structure, such as missing colons or parentheses.
- **Runtime Errors:** Errors that occur while the program is running, such as trying to access an index that does not exist.
- **Logical Errors:** Errors where the code runs without crashing, but the output is not what you expect.

To debug effectively:

- Read error messages carefully to understand what went wrong.
- Use print statements to check variable values at different points in the code.

### **Parallelism**

> Parallelism means maintaining a corresponding structure for subsequent lines or blocks of code.
> 

When writing code, it’s important to maintain parallelism for readability. This means keeping a consistent structure in your code. For example, if you are checking multiple conditions, align them in a similar way:

```python
1 if player_choice == "rock":
2     print("You chose rock.")
3 elif player_choice == "paper":
4     print("You chose paper.")
5 elif player_choice == "scissors":
6     print("You chose scissors.")

```

### Testing

> Testing means to evaluate and verify that the code does what it is supposed to do.
> 

Testing is a crucial part of the development process. It involves running the code with various inputs to ensure that it behaves as expected. Effective testing helps catch errors early and ensures that the code meets its requirements.

> Divide and conquer means dividing a project into sub-projects, solving the sub-projects, and  combining the solutions of the sub-projects to obtain the solution of the original project
> 

In other words, there are three steps to solve a computational (but not strictly computational!) task:  

1. Break the project into subprojects  
2. Solve the subprojects separately  
3. Merge the solutions of the subprojects to obtain the solution of the whole project

What is  an algorithm?  

> An algorithm is a sequence of rigorous steps to execute and complete a task
> 

**Recap**

- An algorithms is a sequence of steps to execute a task
- When writing an algorithm (and code in general), we largely use parallelism, testing, debugging, and divide and conquer
- Debugging helps identify and fix errors in the code.
- Maintaining parallelism in code improves readability.
- Testing is essential to verify that the code functions as intended.
---
Have a play with the content we've learned so far in the IDE below: 

<iframe src="https://trinket.io/embed/python/30d1b8ad2c9f" width="100%" height="400" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
<!-- END section4 -->
<!-- START section5 -->
# Part 5. The while loop and conditions

---

## The while loop

In coding, there are three constructs: if/elif/else, for loops, and while loops. You have now mastered the first two, and in this chapter, you will finally learn the while loop. Read the code below, and  try to understand what it does.

```python
1 # initialize variable
2 number_of_candies = 0
3  
4 # print the initial number of candies 
5 print("You have " + str(number_of_candies) + " candies")
```

We create a variable called number_of_candies and initialize it to 0 (line 2). This variable will keep  count of the number of candies we want.

```python
7 # ask if one wants a candy
8 answer = input ("Do you want a candy? (yes/no)")
9  
10 # as long as the answer is yes as long as the answer is yes 
11 while answer == "yes":
12 
13    # add a candy add a candy 
14    number_of_candies += 1
15
16    # print the current number of candies
17    print("You have " + str(number_of_candies) + " candies")
18 
19    # ask again if they want more candies
20    answer = input ("Do you want more candies? (yes/no)")
21 
22 # print the final number of candies
23 print("You have a total of" + str(number_of_candies) + " candies")
```

Output:

```
You have 0 candies 
Do you want a candy? (yes/no) yes 
You have 1 candies 
Do you want more candies? (yes/no) yes 
You have 2 candies 
Do you want more candies? (yes/no) no 
You have a total of 2 candies
```

Let’s see how the while loop works. We ask the player whether they want a candy, and we save the reply in the variable answer (line 8). Then, we continue with the while loop header, which says  something like: 

as long as the variable answer is equal to yes, do the following (line 11): add a unit  to the variable number_of_candies (line 14); print out the current number of candies (line 17), and ask again the player if they want more candies (line 20). Then, we go back to the while loop header  (line 11). If the answer at line 20 was yes, we’ll do the same as above, that is: add a unit to the variable number_of_candies (line 14); print out the current number of candies (line 17), and ask again the  player if they want more candies (line 20). Then, we will go back to the while loop header again (line  11). If the answer at line 20 was yes again, we will do the same as above once more, that is: add a unit  to the variable number_of_candies (line 14), ... 

We’ll keep doing this as long as the variable answer is  equal to yes. What if the player answers no at line 20? When we go back to the while loop header (line  11), the condition is not valid anymore, because answer is not equal to yes. So the loop stops, and we  go directly to the first line after the while loop body (line 23). There, we print out the total number of  candies.  

Let’s now look into the syntax. The while loop starts with a header (line 11), which is composed of  three parts: 

1. the keyword while, 
2. a condition, and
3.  colon : (every construct header ends with a colon!).

In this example, we check whether the value assigned to the variable answer equals the  string "yes". 

After the header, there is  the body of the while loop (lines 13–20). The body is indented, similarly to the for loop body and  if/elif/else statements. Let’s now focus our attention on two variables: `answer` and  `number_of_candies`.  `answer` is in three different places: 

1. before the while loop (line 8), 
2. in the condition of the while loop, and 
3. in the body of the while  loop. 

Before a while loop, we always have to initialize the variable contained in the condition of the while loop header; otherwise, we cannot evaluate the condition itself  when the loop starts. In our example, we initialize answer with the first player’s answer (line 8). Then, we have to check the condition involving the variable answer. In this case, we check if answer is equal to  yes (line 11). Finally, we have to allow the variable to change (line 20), so that the loop can terminate; otherwise, the loop will keep going indefinitely. 

Let’s finally look into the variable `number_of_candies`. `number_of_candies` is in two places: 

1. before the while loop, where it is initialized (line 2), and
2. in  the while loop, where it is incremented by one unit at every loop (line 14). 

The variable  `number_of_candies` is generally called counter because it keeps count of the number of loops. The  symbol `+=` is an assignment symbol, and we can pronounce it as incremented by. It is a compact way of  writing  `number_of_candies = number_of_candies + 1`. 

For any arithmetic operator, there is the associated  assignment operator, that is, `-=` (decrease by), `*=` (multiply by and reassign), `/=` (divide by and reassign),  etc. 

Note that in assignment operators, the symbol `=` is always in the second position, after an arithmetic operator.

In a while loop we do not know how many times we are going to run the commands in the  loop body because the duration of a while loop depends on the validity of the condition in the header.  Let’s define the while loop and summarize its characteristics:  

> A while loop is the repetition of a group of commands as long as a condition holds
> 

A while loop stops when the condition in the header is not true anymore. We always have to give the variable in the condition the possibility to change so that the condition in the header can be false and the loop can stop. If the variable in the condition (answer in our example) cannot change in the  while loop body, then we will get an infinite loop. Finally, to know how many times we run the loop, we can use a counter (number_of_candies in our example) to keep track of the number of iterations. The presence of a counter is not compulsory.

### **Recap**

- A while loop is the repetition of a bunch of commands as long as a condition holds
- The variable in the condition must be initialized before the condition. It also has to change somewhere in the loop body so that the loop can stop when the condition does not hold anymore
- A while loop can have a counter. Counters keep track of the number of loops and must be initialized  before the loop header
- When updating a variable with an arithmetic operation, we can use the corresponding assignment operator, that is, `+=`, `-=`, etc.

---
<!-- SUBSECTION -->

## Combining and reversing conditions

### `and`

Given the following list of integers: 

```python
1 numbers = [1, 5, 7, 2, 8, 19]
```

Print out the numbers that are between 5 and 10:

```python
1 # for each position in the list
2 for i in range (len(numbers)): 
3  
4    # if the current number is between 5 and 10   
5    if numbers[i] >= 5 and numbers[i] <= 10:
6  
7        # print the current number
8        print ("The number " + str(numbers[i]) + " is between 5 and 10")
```

Output:

```
The number 5 is between 5 and 10 
The number 7 is between 5 and 10 
The number 8 is between 5 and 10
```

We use a for loop to browse all the elements in the list (line 2). Then, we check if each number is  between 5 and 10 (line 5). To be in between two numbers, a number must be greater than or equal  to the smaller number and smaller than or equal to the greater number. The two conditions (greater  than or equal to and smaller than or equal to) must be valid at the same time. To check if two (or more)  conditions are valid simultaneously, we join them using the logical operator `and`.

> We use the logical operator `and` when we want to check  whether all conditions are valid
> 

For each condition both before and after the logical operator and, we have to  write: 

1. a variable (e.g., `numbers[i]`), 
2. a comparison operator (e.g., `>=`), and 
3. a term of comparison  (e.g., `5`). 

At the end of the code, we print the numbers that satisfy both conditions (line 7).

### `or`

Given the following string, and all punctuation:  

```python
1 message = "Have a nice day!!!" [4]: 
2 punctuation = "\"\/'()[]{}<>.,;:?!^@∼\#$%&*_-”
```

The following two symbols `"\"\/` are special characters—you might remember the special  character "`\n`", which is used to go to a new line. The backslash `\` tells Python that the following quote `"` is an actual backslash character and not the symbol that we use to close a string. The last backslash `"\"\ /` is an actual backslash because the following forward slash `/` is not a special  character.

Print and count the number of characters that are punctuation or vowels:

```python
1 # string of vowels 
2 vowels = "aeiou"
3  
4 # initialize counter
5 counter = 0 
6  
7 # for each position in the message
8 for i in range (len(message)):
9  
10    # if the current element is punctuation or vowel  
11    if message[i] in punctuation or message[i] in vowels:  
12 
13       # print a message
14       print (message [i] + " is a vowel or a punctuation")
15 
16       # increase the counter 
17       counter += 1 
18 
19 # print the final amount
20 print("The total amount of punctuation or vowels is " + counter)
```

Output:

```
a is a vowel or a punctuation 
e is a vowel or a punctuation 
a is a vowel or a punctuation 
i is a vowel or a punctuation 
e is a vowel or a punctuation 
a is a vowel or a punctuation 
! is a vowel or a punctuation 
! is a vowel or a punctuation 
! is a vowel or a punctuation 
The total amount of punctuation or vowels is 9
```

Similarly to what we did for punctuation, we create a string containing vowels (line 2). We also create  a counter, which we will use to calculate the number of characters that are punctuation or vowels, and we initialize it to zero (line 5). 

We use a for loop to browse  all the characters in the string message (line 8). For loops for strings work exactly the same way as for loops for lists. In the loop body, we check if each character is a punctuation or a vowel by using  the membership operator in (line 11). More specifically, we check  if `message[i]` is in the string `punctuation` or in the string `vowels`. Note that as for the for loop, the  membership operator in works for strings the same way as it works for lists. Since only one of the  conditions can be valid (a character cannot be both a punctuation and a vowel at the same time!), we merge the two conditions—that is, `message[i]` in `punctuation` or `message[i]` in `vowels`—using the logical operator `or`.  

> We use the logical operator `or` when we want to check whether at least one condition is valid
> 

The syntax is the same as for the logical operator `and`: we need to write 

1. a variable, 
2. a comparison operator, and 
3. a term of comparison both before and after or. 

To conclude the loop body, we print a  message for the characters that satisfy at least one condition (line 14), and we increment the counter  by one unit (line 17). At the end of the loop, we print the final number of characters that are vowels  or punctuation (line 20).

### `not`

Given the following list of integers:  

```python
1 numbers = [4, 6, 7, 9] numbers is assigned four, six, seven, nine 
```

Print out the numbers that are not divisible by 2:  

```python
1 # for each position in the list
2 for i in range (len(numbers)): 
3  
4    # if the current number is not even 
5    if not numbers[i] % 2 == 0: 
6  
7       # print the current number 
8       print (numbers[i])
```

For each position in the list (line 2), we have to check whether the number is *not* even. For a moment,  let’s think about the opposite: what condition would we write if we had to check whether the number  is even? if `numbers[i] % 2 == 0`. To negate a condition, we just add the logical operator `not` before the condition—more specifically, before the variable at the beginning of the condition (line 5).  

> We use the logical operator `not` when we want to check  whether the opposite of a condition is valid
> 

If the condition is satisfied, then we print the number (line 8).

### `not in`

Generate 5 random numbers between 0 and 10. If the random numbers are not already in the following list, then add them: 

```python
1 numbers = [1, 4, 7]
```

```python
 1 import random 
 2  
 3 # for five times 
 4 for _ in range (5): 
 5  
 6    # generate a random number between 0 and 10 
 7    number = random.randint(0, 10)
 8    # print the number as a check
 9    print (number) print number 
 10 
 11    # if the new number is not in numbers 
 12    if number not in numbers: 
 13       # add the number to numbers 
 14       numbers.append(number)
 15 
 16 # print the final list
 17 print (numbers)
```

Output:

```
6 
6 
10 
7 
9  
[1, 4, 7, 6, 10, 9]
```

We start by importing the package `random` (line 1). Then, we create a for loop that runs for five times (line 4)—note the underscore instead of the variable `i` because we will not need any index in the for loop body. Then, we create a random variable (line 7) and print it as a check (line 9). To evaluate if the variable number is not already in the list `numbers` (line 12), we use the membership operator `not in`, which is the opposite of the membership  operator in (Chapter 3). If the condition is met, then we append the randomly generated number to  the list of numbers (line 14). Finally, we print the completed list (line 17).

### Recap

- The logical operators are `and`, `or`, and `not`
- When combining conditions, the order of execution is `not`, `and`, `or` (NAO)
- The membership operators are `in` and `not in`

---

<!-- SUBSECTION -->

## Booleans

> Booleans are a variable type. They can have only two values: True or False
> 

### Single Comparison or Condition

Assign the above operation to a variable and print it.

```python
1 result = number > 3
2 print (result) 
3 type (result) 
```

Output:

True 

bool  

We assign the result of the comparison operation number > 3 to the variable result (line 1). Then, we  print result (line 2) and we get True—like in cell 2. Finally, we print the outcome of type(result) to  determine the type of the variable result (line 3)—we mentioned the built-in function `type()`. We say that the variable result is of type Boolean and its value is True. Booleans are a data  type exactly like strings, lists, integers, etc.  

### Combining comparisons or conditions

What is the outcome of the following comparison operations?  

```python
1 number = 3 
2 print (number > 1)
3 print (number < 5) 
4 print (number > 1 and number < 5)
```

Output:

True 

True 

True

We assign `3` to the variable `number` (line 1). Then, we print the outcome of three comparison operations. For all operations—number > 1 (line 2), number < 5 (line 3), and number > 1 and number <  5 (line 4)—the outcome is `True`. Let’s focus on line 4, where we combine two comparison operations  with the logical operator `and`. 

If `number = 3,` the first condition is now `False` because 3 is not larger than 4 (line 2), whereas the second condition  is still `True` (line 3). The combination of the `False` condition from line 2 with the `True` condition from line 3 returns False (line 4).

We can summarize the outcome of combinations of conditions using the logical operators and in a truth table:

`and`:

| First Condition | Second Condition | First Condition and Second Condition |
| --- | --- | --- |
| True | True | True |
| False | True | False |
| True | False | False |
| False | False | False |

`or`:

| **First Condition** | **Second Condition** | **First Condition or Second Condition** |
| --- | --- | --- |
| True | True | True |
| False | True | True |
| True | False | True |
| False | False | False |

`not`:

| Condition | Not Condition |
| --- | --- |
| True | False |
| False | True |

### Where else do we use Booleans?

Booleans are often used as flags in while loops. This means they help control the flow of the loop.

```python
1  # Initialize variable
2  number_of_candies = 0
3
4  # Use a Boolean as a flag
5  flag = True
6
7  # Print the initial number of candies
8  print("You have " + str(number_of_candies) + " candies")
9
10 # As long as the flag is True
11 while flag:
12     # Ask if they want a candy
13     answer = input("Do you want a candy? (yes/no)")
14
15     # If the answer is yes
16     if answer == "yes":
17         # Add a candy
18         number_of_candies += 1
19         # Print the total number of candies
20         print("You have " + str(number_of_candies) + " candies")
21     else:
22         # Print the final number of candies
23         print("You have a total of " + str(number_of_candies) + " candies")
24         # Stop the loop by assigning False to the flag
25         flag = False
```

### **Recap**

- When we write a comparison or a condition, the outcome is a `Boolean` variable
- Booleans are a Python type, like lists, strings, integers, etc.
- There are only 2 Boolean values: `True` and `False`
- Combinations of conditions using `and`, `or`, `not` follow the truth tables
- Booleans can be used as flags in while loops (they act like traffic lights)
<!-- END section5 -->
<!-- START section6 -->
# Part 6. Recap of lists and for loops

---

## Overview of Lists

In this chapter, we will recap the key concepts related to lists in Python, including their methods and operations. Lists are a fundamental data structure that allows us to store multiple items in a single variable.

### **What is a List?**

> A list is a sequence of elements separated by commas and enclosed in square brackets `[]`.
> 

Lists can contain elements of various data types, including strings, integers, and even other lists. They are mutable, meaning we can change their content after creation.

### **Creating a List**

You can create a list by simply assigning values to a variable:

```python
1 my_list = [1, 2, 3, 4, 5]  # A list of integers
2 fruits = ["apple", "banana", "cherry"]  # A list of strings

```

### **Accessing List Elements**

You can access elements in a list using their index, which starts at 0:

```python
3 print(my_list[0])  # Output: 1
4 print(fruits[1])   # Output: banana

```
<!-- SUBSECTION -->

### **List Methods**

Lists come with several built-in methods that allow us to manipulate their contents. Here are some important methods:

| List Method | What it Does |
| --- | --- |
| `.append()` | Adds an element to the end of the list. |
| `.remove()` | Removes the first occurrence of a specified value. |
| `.pop()` | Removes and returns an element at a specified index (default is the last element). |
| `.index()` | Returns the index of the first occurrence of a specified value. |
| `.sort()` | Sorts the elements of the list in ascending order. |
| `.reverse()` | Reverses the order of the elements in the list. |
| `.clear()` | Removes all elements from the list. |

### **Using List Methods**

Here’s how to use some of these methods in practice:

```python
5 fruits.append("orange")  # Adds "orange" to the end of the list
6 fruits.remove("banana")  # Removes "banana" from the list
7 last_fruit = fruits.pop()  # Removes and returns the last fruit
8 print(fruits)  # Output: ['apple', 'cherry', 'orange']

```

### **List Operations**

You can perform various operations on lists, such as concatenation and repetition:

```python
9 combined_list = my_list + [6, 7, 8]  # Concatenates two lists
10 repeated_list = fruits * 2  # Repeats the list twice

```

### **Recap of List Characteristics**

- Lists are ordered collections of items.
- They can contain mixed data types.
- Lists are mutable, allowing for modification.
- They support various methods for manipulation.

### **Recap**

- We can perform element-wise operations in lists using the arithmetic operators `+,-, *, /, **, //, %`
- We can perform “arithmetic” operations on lists using concatenation `+` and replication `*`
- The 11 methods for lists are: `.append()`, `.clear()`, `.copy()`, `.count()`, .extend(), `.index()`,  `.insert()`, `.pop(),` `.remove()`, `.reverse()`, `.sort()`
- Of the 11 methods, the 3 methods that return a new value are .`copy()`, `.count()`, and `.index()` . The other 8 methods modify the lists themselves

---

## Various ways of repeating commands on lists and beyond

The for loop is incredibly flexible.

Let’s explore the many ways we can use it — with lists, strings, ranges, and more.

### **Repeating commands on list elements**

You already know how to loop through a list:

```python
1 fruits = ["apple", "banana", "cherry"]
2 for fruit in fruits:
3     print(fruit)

```

Output:

```
apple
banana
cherry
```

**Explanation:**

- Line 2: `for fruit in fruits` means: for each element inside the list `fruits`, assign it temporarily to `fruit`.
- Line 3: `print(fruit)` outputs the current item.

<!-- SUBSECTION -->

### **For loop with lists**

There are at least 4 ways to use the for loop with lists. 

1. **For loop through indices**  
    
    You already know this for loop type. Let’s refresh our memories with the following example.  
    
    Capitalise each string using a for loop through indices:
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"] 
    2  
    3 for i in range (len(last_names)): 
    4    print ("The element in position " + str (i) + " is: " + last_names[i])
    5    last_names[i] = last_names[i].title() 
    6  
    7 print (last_names)
    ```
    
    Output:
    
    ```
    The element in position 0 is: garcia 
    The element in position 1 is: smith 
    The element in position 2 is: zhang 
    ['Garcia', 'Smith', 'Zhang']
    ```
    
2. **For loop through elements**  
    
    Let’s learn the first new way of implementing the for loop: the for loop through elements. Read the  example below and try to understand what it does: 
    
    Capitalise each string using a for loop through elements:  
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"] 
    2 last_names_upper = [] 
    3  
    4 for last_name in last_names: 
    5    print ("The current element is " + last_name) 
    6    last_names_upper.append(last_name.title()) 
    7  
    8 print (last_names_upper) 
    ```
    
    Output:
    
    ```
    The current element is: garcia 
    The current element is: smith 
    The current element is: zhang 
    ['Garcia', 'Smith', 'Zhang']
    ```
    
    As in the previous example, we start with the list to modify (line 1). We continue with a new empty list called `last_names_upper` that we will fill within the loop (line 2). Then, we create the for loop through elements (lines 4–6). The syntax of the header is: 
    
    1. the keyword for; 
    2. a variable; 
    3. the membership operator in; and 
    4. the list to browse. 
    
    There are two differences with respect to the for loop through indices. First, the variable in position (2) is not named index or i, but it is usually called with  the singular version of the list name—that is, if the list name is `last_names`, then the variable name is  `last_name`; if the list name is numbers, then the variable name is number; and so on. This is not a rule  but a useful convention among Python coders. The second difference is that we directly use the list  itself—that is, `last_names`—in position (4), instead of `range(len(last_names))`. 
    
    Let’s now focus on  the loop body. First, we print the current element `last_name` (line 5). As you may notice, there is no  slicing (that is, no `[i]`). This is because in a for loop through elements, the variable in position(2) that is, `last_name`—automatically browses list elements one after the other, without knowing their  position. This is the opposite of what happens in a for loop through indices, where the variable in position (2)—that is, `i`—browses list positions without knowing the corresponding elements; to get an  element, we must use slicing (e.g., `last_name[i])`. See a schematic of the difference between the two  loops in Figure 6.1.
    
    ![Figure 6.1. Schematics of a for loop through indices, where an index browses positions (orange), and a for loop through elements, where a variable browses elements (yellow).](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%203.png)
    
    Figure 6.1. Schematics of a for loop through indices, where an index browses positions (orange), and a for loop through elements, where a variable browses elements (yellow).

<!-- SUBSECTION -->
    
3. **For loop through indices and elements**  
    
    As the name implies, the for loop through indices and elements combines a for loop through indices with a for loop through elements. Its implementation is straightforward. Try to understand the example  below before reading the subsequent explanation. 
    
    Capitalise each string using a for loop through indices and elements:
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"]
    2  
    3 for i,last_name in enumerate (last_names): 
    4    print ("The element in position " + str (i) + " is: " + last_name)
    5    last_names[i] = last_name.title()
    6  
    7 print (last_names) 
    ```
    
    Output:
    
    ```
    The element in position 0 is: garcia 
    The element in position 1 is: smith 
    The element in position 2 is: zhang 
    ['Garcia', 'Smith', 'Zhang']
    ```
    
    The for loop header consists of 
    
    1. the keyword for; 
    2. two variables separated by comma`,` called  `i` and `last_name`;
    3. the membership operator `in`; and 
    4. the built-in function `enumerate()` with the  list `last_names` as an argument (line 3).
    
    The differences with the other for loop headers is again in the components (2) and (4). The role of `i` and `last_name` is quite intuitive: `i` is the index that browses all  the positions in the list—like in a for loop through indices—and `last_name` is the variable that browses  all the elements in the list—like in a for loop through elements. 
    
    The built-in function `enumerate()` provides a list of coupled indices and elements—that is, `(0,  'garcia')`, `(1, 'smith')`, and `(2, 'zhang')`. Each pair is between round brackets, which indicate a tuple. 
    
    > Tuples are sequences of elements separated by comma and in between round brackets.
    > 
    
    During the for loop in this example, the variable `i` is assigned the first element of each pair—that is, 0, 1, and 2—and the variable `last_name` is assigned the second element of each pair—that is, ‘garcia', ‘smith', and `zhang'. In the remaining part of the  example, first we print the position of each element `i` and its value `last_name` (line 4). Then, we apply the method `.title()` to l`ast_name`, and we assign the result to the element in the same position  `last_names[i]` (line 5). Finally, we print the resulting list (line 6). The **for loop through indices and  positions is useful when we need to extract both positions and elements of a whole list.**
    
<!-- SUBSECTION -->

4. **List Comprehension**
    
    The fourth and last method to use a for loop in combination with lists is called list comprehension. It might look complex at first glance, but we are going to untangle it right away!  - 
    
    - Capitalize each string using list comprehension containing a for loop through indices:  [
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"] 
    2 last_names = [last_name.title() for i in range(len(last_names))] 
    3 print (last_names) print last names 
    ```
    
    Output:
    
    ```
    ['Garcia', 'Smith', 'Zhang']  
    ```
    
    At line 2, we see:
    
    1. the list name; 
    2. the assignment symbol; and 
    3. the list comprehension. 
    
    In the list  comprehension, there are two components embedded within a pair of square brackets: 
    
    1. the value  of the list element that we are going to insert into the list—that is, last_name.title(); and 
    2. a for  loop header—that is, for i in range(len(last_names)).
    
    To better understand the syntax, let’s have  a look at Figure 6.2 comparing the for loop through indices from cell 2 and the list comprehension from the cell above.
    
    ![Figure 6.2 Comparison between a for loop through indices (lines a–b) and list comprehension (line c)](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%204.png)
    
    Figure 6.2 Comparison between a for loop through indices (lines a–b) and list comprehension (line c)
    
    As you can see, the components of a list comprehension are the same as the components of a for  loop, just in a somewhat inverted position. In a for loop, first we write the header (line (a); orange  rectangle), and then we assign the modified element (yellow rectangle) to the element itself (line (b)).  In a list comprehension (line (c)), we write first the modified element (yellow rectangle) and then the  for loop header (orange rectangle). 
    
    As you can see, list comprehension is a one-line command to  create or modify a list in a fast and compact way. We conclude the previous example by printing the  new list (line 3). 
    
    We can write a list comprehension containing the header of a for loop through elements
    
    - Capitalize each string using list comprehension containing a for loop through elements:
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"] 
    2 last_names = [last_name.title() for last_name in last_names]
    3 print (last_names) 
    ```
    
    Output: 
    
    ```
    ['Garcia', 'Smith', 'Zhang']  
    ```
    
    Similarly to before, in the list comprehension we write first the new element of the list—that is,  l`ast_name.title()`—and then the header of a for loop through elements—that is, for `last_name` in  `last_names` (line 2). 
    
    Another interesting characteristic of list comprehensions is that they can contain a conditional construct. 
    
    - Keep and capitalize only the elements shorter than 6 characters:
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"]
    2 last_names = [last_name.title() for last_name in last_names if len(last_name) < 6]
    3 print (last_names) 
    ```
    
    Output:
    
    ```
    ['Smith', 'Zhang']  
    ```
    
    We modify the code from cell 6 by adding an **if condition at the end** of the list comprehension (line 2). 
    
    Finally, list comprehensions are extremely useful to delete list elements based on conditions. In cell 16 of the previous Chapter, we used a while loop containing `.remove()` to delete several elements  with similar characteristics. Now, let’s learn how to delete elements in a much more compact way  with list comprehension. 
    
    - Delete elements that are composed of 5 characters:
    
    ```python
    1 last_names = ["garcia", "smith", "zhang"]
    2 last_names = [last_name.title() for last_name in last_names if len(last_name) != 5]
    3 print (last_names) 
    ```
    
    Output:
    
    ```
    ['garcia']  
    ```
    
    When deleting elements with list comprehensions, we have to think about the elements that we are  going to keep, not about those that we are going to delete. This is because in a list comprehension, in the first position we must write the element that we are going to insert into the list. Thus, if we want to delete the elements whose length is 5, we need to reverse our thinking and write the condition that  allows us to keep the elements whose length is not equal to 5—that is if `len(last_name) != 5` (line  2).
    
<!-- SUBSECTION -->

### **Nested `for` loops**

> A nested for loop is a for loop within another for loop.
> 
- Given the following list of vowels:

```python
1 vowels = ["A", "E", "I", "O", "U"]  
```

We start with a list of strings (line 1).

- For each vowel, print all the vowels on the right:

```python
1 for i in range (len(vowels)):
2    print ("-- " + vowels[i]) 
3    for j in range (i + 1, len(vowels)):
4        print (vowels[i]) 
```

Output:

```
-- A 
E 
I 
O 
U  
-- E 
I 
O 
U  
-- I 
O 
U  
-- O 
U  
-- U  
```

The nested for loop in this example is composed of an **outer for loop**, whose header is at line 1, and **an inner for loop**, whose header is at line 3. In the outer for loop, the index `i` goes from `0` (omitted) to the length of the list (line 1); thus, `i` will browse all list positions. In the inner for loop, the index `j` goes  from `i+1` to the length of the list (line 3); thus, `j` will browse all remaining list positions on the right of  the current position `i`. For each iteration of the outer loop, the inner loop has to be completed before  moving to the next iteration of the outer loop. 

Here is what happens at each loop:  

- In the first outer loop, `i` is `0`. We print:
    
    ```python
    "-- " + vowels[0]  # Output: -- A
    
    ```
    
    Then, we run the whole inner `for` loop:
    
    ```python
    for j in range(i+1, len(vowels)):
    
    ```
    
    Since `i + 1 = 1` and `len(vowels) = 5`, `j` will go through `[1, 2, 3, 4]`. Therefore, in the inner loop:
    
    - In the first iteration, `j = 1`, we print `vowels[1]` → `E`
    - In the second iteration, `j = 2`, we print `vowels[2]` → `I`
    - In the third iteration, `j = 3`, we print `vowels[3]` → `O`
    - In the fourth iteration, `j = 4`, we print `vowels[4]` → `U`
    
    The inner loop is completed, and we return to the outer loop.
    
- In the second outer loop, `i = 1`. We print:
    
    ```python
    "-- " + vowels[1]  # Output: -- E
    
    ```
    
    Now `j` starts at `2` and goes to `4`:
    
    - First iteration: `j = 2`, print `vowels[2]` → `I`
    - Second iteration: `j = 3`, print `vowels[3]` → `O`
    - Third iteration: `j = 4`, print `vowels[4]` → `U`
    
    Back to the outer loop.
    
- In the third outer loop, `i = 2`, so we print:
    
    ```python
    "-- " + vowels[2]  # Output: -- I
    
    ```
    
    Then the inner loop runs for `j = 3` and `4`:
    
    - `j = 3`, print `vowels[3]` → `O`
    - `j = 4`, print `vowels[4]` → `U`
- In the fourth outer loop, `i = 3`, so we print:
    
    ```python
    "-- " + vowels[3]  # Output: -- O
    
    ```
    
    Inner loop only runs for `j = 4`:
    
    - `j = 4`, print `vowels[4]` → `U`
- In the last outer loop, `i = 4`, we print:
    
    ```python
    "-- " + vowels[4]  # Output: -- U
    
    ```
    
    No inner loop is executed here because `i + 1 = 5`, which matches the loop stop condition.
    

We can have more loops nested within each other. As a convention, the index names are `i`, `j`,  `k`, etc. However, it is strongly recommended not to use too many for loops because they are computationally very expensive, that is, they use a lot of memory and time.

### **Recap**

- When we use a for loop to repeat commands that do not need the index, we substitute the index with an underscore
- There are at least 4 types of for loops with lists: through *indices* (uses `range()`), through *elements*, through *indices and elements* (uses `enumerate()`), and list comprehension
- The built-in functions `list()` can be used to transform the output of `range()` and `enumerate()` into a list
- The built-in function `enumerate()` simultaneously extracts coupled indices and elements from a list
- Tuples are sequences of elements separated by commas and in between round brackets
- Nested for loops are for loops within for loops

---

<!-- SUBSECTION -->

## Slicing, nested for loops, and flattening

> A list of lists is a list whose elements are lists
> 

### **Slicing**

A list of lists is a list whose elements are lists. Lists of lists follow the same rules as lists; they just add an “extra layer” of indices. In this Chapter, you will learn how to slice lists of lists, use nested for loops to iterate through them, and explore ways to flatten them. Follow along with Notebook 23.

- Given the following list of lists:

```python
1 animals = [["dog", "cat"], ["cow", "sheep", "horse", "chicken", "rabbit"], ["panda", "elephant", "giraffe", "penguin"]]

```

The list of lists `animals` is composed of three elements, which are the lists `["dog", "cat"]`, `["cow", "sheep", "horse", "chicken", "rabbit"]`, and `["panda", "elephant", "giraffe", "penguin"]`. We call each of these lists sub-lists and their elements ("dog", "cat", "cow", etc.) sub-elements.

- Print the sub-lists:

```python
1 print(animals[0])
2 print(animals[1])
3 print(animals[2])
```

Output:

```
['dog', 'cat']
['cow', 'sheep', 'horse', 'chicken', 'rabbit']
['panda', 'elephant', 'giraffe', 'penguin']
```

- Print the sub-elements "cat", "rabbit", and from "panda" to "giraffe":

```python
1 print(animals[0][1])
2 print(animals[1][-1])
3 print(animals[2][:3])

```

Output:

```
cat
rabbit
['panda', 'elephant', 'giraffe']

```

<!-- SUBSECTION -->

To extract sub-elements, we use double slicing, where the **first slicing—indicated by the first pair of  square brackets—extracts a sub-list and the second slicing—indicated by the second pair of square  brackets—extracts one or more sub-elements**. 

To extract the sub-element `"cat"`, first we extract the sub-list of pets `animals[0]`, which is `['dog', 'cat']`. Then, from that sub-list, we slice `"cat"` at position `1` using `animals[0][1]`.

The string `"rabbit"` is the last element of the second sub-list of farm animals. So we access it with `animals[1][-1]`.

The sub-elements from `"panda"` to `"giraffe"` are within `animals[2]`, and we slice it with `animals[2][:3]` to get the first three elements.

### **Nested For Loops**

To browse elements in a list of lists, we can use a nested for loop, where the **outer loop browses the list of lists and the inner loop browses the sub-lists.**

- Given the following list of lists:

```python
1 sports = [["skiing", "skating", "curling"], ["canoeing", "cycling", "swimming", "surfing"]]

```

- Print the sub-list elements one-by-one using a nested for loop through indices:

```python
1 for i in range(len(sports)):
2     for j in range(len(sports[i])):
3         print(sports[i][j])
```

Output:

```
skiing
skating
curling
canoeing
cycling
swimming
surfing

```

- First outer loop (`i = 0`):
    - `j = 0` → `print(sports[0][0])` → "skiing"
    - `j = 1` → `print(sports[0][1])` → "skating"
    - `j = 2` → `print(sports[0][2])` → "curling"
- Second outer loop (`i = 1`):
    - `j = 0` → `print(sports[1][0])` → "canoeing"
    - `j = 1` → `print(sports[1][1])` → "cycling"
    - `j = 2` → `print(sports[1][2])` → "swimming"
    - `j = 3` → `print(sports[1][3])` → "surfing"
- After the second outer loop, there are no more sub-lists.

Can we do the same with a for loop through elements? Yes! Think about how we might go about doing this before looking into the following code.

- Print the sub-list elements one-by-one using a nested for loop through elements:

```python
for seasonal_sports in sports:
    for sport in seasonal_sports:
        print(sport)

```

Output:

```
skiing
skating
curling
canoeing
cycling
swimming
surfing

```

Explanation of the flow:

- In the **first iteration** of the outer for loop, `seasonal_sports_list` is `["skiing", "skating", "curling"]`, and the inner for loop goes through:
    - **First inner loop**: `sport` is "skiing".
    - **Second inner loop**: `sport` is "skating".
    - **Third inner loop**: `sport` is "curling".
- After the first sub-list is fully iterated, the outer for loop moves to the **second iteration**, where `seasonal_sports_list` is `["canoeing", "cycling", "swimming", "surfing"]`, and the inner for loop goes through:
    - **First inner loop**: `sport` is "canoeing".
    - **Second inner loop**: `sport` is "cycling".
    - **Third inner loop**: `sport` is "swimming".
    - **Fourth inner loop**: `sport` is "surfing".

The inner for loop finishes, and the outer loop completes as well after going through all sub-lists.

<!-- SUBSECTION -->

### **Flattening**

**Flattening means transforming a list of lists into a list**. In other words, we take the sub-elements out of their sub-lists and we put them in a list.

- Given the following list of lists:

```python
instruments = [["contrabass", "cello", "clarinet"], ["gong", "guitar"], ["tambourine", "trumpet", "trombone", "triangle"]]

```

- Flatten the list using a nested for loop through indices:

```python
flat_instruments = []
for i in range(len(instruments)):
    for j in range(len(instruments[i])):
        flat_instruments.append(instruments[i][j])

print(flat_instruments)

```

Output:

```
['contrabass', 'cello', 'clarinet', 'gong', 'guitar', 'tambourine', 'trumpet', 'trombone', 'triangle']

```

Explanation of the flow:

We start with the empty list `flat_instruments` that will be populated during the nested loops (line 1).

The **outer for loop** (line 2) iterates over each position in the `instruments` list of lists.

- In the **first iteration**: `instruments[i]` is `["piano", "guitar", "violin"]`.
    - The **inner for loop** (line 3) goes through each position in that sub-list:
        - `flat_instruments` gets the values: "piano", "guitar", and "violin".
- In the **second iteration**: `instruments[i]` is `["drums", "flute", "saxophone"]`.
    - The **inner for loop** (line 3) again goes through each element:
        - `flat_instruments` gets the values: "drums", "flute", and "saxophone".

Finally, we print the `flat_instruments` list (line 5), which is now a flattened list of all the sub-elements from `instruments`.

- Flatten the list using a nested for loop through elements:

```python
flat_instruments = []
for group in instruments:
    for instrument in group:
        flat_instruments.append(instrument)

print(flat_instruments)
```

Output:

```
['contrabass', 'cello', 'clarinet', 'gong', 'guitar', 'tambourine', 'trumpet', 'trombone', 'triangle']
```

Explanation:

We start with an empty list `flat_instruments` (line 1).

The **outer for loop** (line 2) iterates through each sub-list (`group`) in `instruments`.

The **inner for loop** (line 3) iterates through each element (`instrument`) in the current `group`.

Each `instrument` is appended to `flat_instruments` (line 4).

Finally, we print the flattened list (line 5).

- Flatten the list using a for loop and list concatenation:

```python
flat_instruments = []
for group in instruments:
    flat_instruments += group

print(flat_instruments)

```

Output:

```
['contrabass', 'cello', 'clarinet', 'gong', 'guitar', 'tambourine', 'trumpet', 'trombone', 'triangle']
```

Explanation:

We start with the empty list `flat_instruments` (line 1).

The **for loop** (line 2) iterates through each sub-list (`group`) in `instruments`.

Instead of using `append()`, we concatenate each `group` (sub-list) directly to `flat_instruments` using the `+=` operator (line 3).

Finally, we print the flattened list (line 4).

- Flatten the list using list comprehension:

```python
instruments = [instrument for group in instruments for instrument in group]
print(instruments)

```

Output:

```
['contrabass', 'cello', 'clarinet', 'gong', 'guitar', 'tambourine', 'trumpet', 'trombone', 'triangle']

```

Explanation:

List comprehension allows us to flatten the list directly (line 1).

The syntax `[instrument for group in instruments for instrument in group]` essentially combines the two `for` loops into one compact expression. It means:

- For each `group` in `instruments`, and for each `instrument` in that `group`, include `instrument` in the new list.

Finally, we print the flattened list (line 2).

<!-- SUBSECTION -->

### **Recap**

- Lists of lists are lists with lists as elements.
- When slicing, we use two pairs of square brackets.
- We can use nested for loops to browse sub-elements.
- We can flatten a list of lists using:
    - Nested for loops
    - List concatenation
    - List comprehension
<!-- END section6 -->
<!-- START section7 -->
# Part 7. Dictionaries and overview of strings

---

## Dictionaries

You already know several data types: strings, lists, integers, floats, and Booleans. In this Chapter, you will learn a new data type called *dictionary*. What are dictionaries and what can we do with them? Let’s start from this example. 

- You are the owner of an English bookstore, and these are some classics you sell:

```python
1 classics = {"Austen": "Pride and Prejudice", "Shelley": "Frankenstein", "Joyce": "Ulyssessss"}
2 print(classics)
```

`classics` is assigned `Austen:Pride and Prejudice`, `Shelley:Frankenstein`, `Joyce:Ulyssessss`

At line 1, there is a variable called `classics` to which we assign a sequence of items separated by commas and enclosed within curly brackets `{}`. Each item (e.g., `"Austen":"Pride and Prejudice"`) is composed of a key (`"Austen"`) and a value (`"Pride and Prejudice"`), which are separated by a colon `:`.

Thus, we can define a dictionary as follows:

> A dictionary is a sequence of `key:value` pairs separated by commas `,` and in between curly brackets `{}`.
> 
- You are conducting an inventory, and you need to print authors and titles:

```python
1 # as dict_items
2 print(classics.items())
3 # as a list of tuples
4 print(list(classics.items()))

```

Output:

```
dict_items([('Austen', 'Pride and Prejudice'), ('Shelley', 'Frankenstein'), ('Joyce', 'Ulyssessss')]) 
[('Austen', 'Pride and Prejudice'), ('Shelley', 'Frankenstein'), ('Joyce', 'Ulyssessss')]
```

To print the dictionary items, we use the method `.items()`, which extracts items from a dictionary (line 2). As you can see in the printout, `.items()` returns a specific type called `dict_items`, which contains a list whose elements are the items. We can ignore `dict_items` and print the contained list by enclosing the method output into the built-in function `list()` (line 4).

- Then, you need to print authors and titles separately:

```python
1 # authors as dict_items
2 print(classics.keys())
3 # authors as a list
4 print(list(classics.keys()))
5
6 # titles as dict_items
7 print(classics.values())
8 # titles as a list
9 print(list(classics.values()))

```

Output:

```
dict_keys(['Austen', 'Shelley', 'Joyce']) ['Austen', 'Shelley', 'Joyce'] 
dict_values(['Pride and Prejudice', 'Frankenstein', 'Ulyssessss']) ['Pride and Prejudice', 'Frankenstein', 'Ulyssessss']
```

To extract dictionary keys, we use the method `.keys()` (line 2). Like `.items()`, `.keys()` returns its datatype, called `dict_keys` (line 4). To extract the list of keys from the `dict_keys`, we can use the built-in function `list()`. Finally, to extract dictionary values, we use the method `.values()` (line 7), which returns the list of values embedded in another datatype called `dict_values`. Once again, to extract the list of values, we use `list()` (line 9).

- You notice that the title of the last book is wrong, so you correct it:

```python
1 print("Wrong title: " + classics["Joyce"])
2 classics["Joyce"] = "Ulysses"
3 print("Corrected title: " + classics["Joyce"])

```

Output:

```
Wrong title: Ulyssessss 
Corrected title: Ulysses
```

To slice a value, the syntax is `dictionary[key]` (pronunciation: dictionary at key), as we can see in `classics["Joyce"]` (line 1).  Let’s analyze some similarities and differences between dictionaries and lists with the help of Figure 7.1. In a list, there are elements (e.g., `"burger"`, `"salad"`, `"coke"`)—which are the content of a list—and corresponding indices (e.g., `0`, `1`, `2`)—which define the position of each element. When we want to extract (or slice) an element, we write the name of the list and the index of the element that we want in between squared brackets (`list[index]`). Thus, `todays_menu[0]` gives us `"burger"`. 

Similarly, in a dictionary, there are values (e.g., `"Pride and Prejudice"`, `"Frankenstein"`, `"Ulysses"`)—which are the content of a dictionary—and keys (e.g., `"Austen"`, `"Shelley"`, `"Joyce"`)—which define the position of each value. When we want to access (or slice) a value, we indicate the name of the dictionary and the key corresponding to the value that we want in between squared brackets (`dictionary[key]`). Thus, `classics["Austen"]` gives us `"Pride and Prejudice"`. 

The main difference between lists and dictionaries lies in the way we define the position of an element or value. In lists, indices order elements from position 0 to position `len(list)-1`, in a consecutive and progressive way (we cannot skip a position). On the other side, in dictionaries, keys are in no specific order. Also, note that numbers cannot be used as keys.

![Figure 7.1. Comparing structure and slicing syntax for lists (top) and dictionaries (bottom).](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%205.png)

Figure 7.1. Comparing structure and slicing syntax for lists (top) and dictionaries (bottom).

As we cannot change indices but only elements in lists, we cannot change keys but only values in dictionaries. As you might have noticed, in the item `"Joyce":"Ulyssessss"`, we need to correct `"Ulyssessss"` to `"Ulysses"`. To do so, we overwrite the value `"Ulyssessss"` using the same syntax as that used in slicing: `classics["Joyce"] = "Ulysses"` (line 2). Once more, this is the same syntax as that used in lists (e.g., if we want to change `"coke"` to `"water"`, we write `todays_menu[2] = "water"`). At the end of cell 4, we check the correction by printing a string (`"Corrected title: "`) concatenated with the sliced new value (`classics["Joyce"]`, which is `"Ulysses"`; line 3).

- Then you add two new books that have just arrived: Gulliver’s Travels by Swift and Jane Eyre by Bronte:

```python
1 # adding the first book (syntax 1)
2 classics["Swift"] = "Gulliver's travels"
3 print(classics)
4
5 # adding the second book (syntax 2)
6 classics.update({"Bronte": "Jane Eyre"})
7 print(classics)
```

Output:

```
{'Austen': 'Pride and Prejudice', 'Shelley': 'Frankenstein', 'Joyce': 'Ulysses', 'Swift': 'Gulliver's travels'} 
{'Austen': 'Pride and Prejudice', 'Shelley': 'Frankenstein', 'Joyce': 'Ulysses', 'Swift': 'Gulliver's travels', 'Bronte': 'Jane Eyre'}
```

The first way is to use a slicing-like syntax, where we write: 

1. dictionary name (`classics`); 
2. new key in between square brackets (`["Swift"]`); 
3. assignment symbol (`=`); and 
4. new value (`"Gulliver's travels"`) (line 2). 

The second way is to use the method `.update()`. As an argument, we use a key:value pair in between curly brackets—that is, a dictionary! (line 6). To make sure that we added items correctly, we print the dictionary after every modification (lines 3 and 7).

- Finally, you remove the books by Austen and Joyce because you have just sold them:

```python
1 # deleting the first book (syntax 1)
2 del classics["Austen"]
3 print(classics)
4
5 # deleting the second book (syntax 2)
6 classics.pop("Joyce")
7 print(classics)

```

Output:

```
{'Shelley': 'Frankenstein', 'Joyce': 'Ulysses', 'Swift': 'Gulliver's travels', 'Bronte': 'Jane Eyre'} 
{'Shelley': 'Frankenstein', 'Swift': 'Gulliver's travels', 'Bronte': 'Jane Eyre'}
```

Also in this case, there are two possibilities. The first way to delete an item is to use the keyword `del`, followed by the dictionary name and the key enclosed within square brackets (`classics["Austen"]`; line 2). The second way is to use the method `.pop()`, with the key of the item to delete as an argument (line 6). (Once more, this is similar to lists, where we use the method `.pop()` to delete an element based on its position.) After each deletion, we print the dictionary to check for correctness (lines 3 and 7).

<!-- SUBSECTION -->

| **Dictionary Method** | **What it does** |
| --- | --- |
| `.items()` | Returns a view object that displays a list of a dictionary's key:value pairs. |
| `.keys()` | Returns a view object that displays a list of all the keys in the dictionary. |
| `.values()` | Returns a view object that displays a list of all the values in the dictionary. |
| `.update()` | Adds key:value pairs to the dictionary, or updates the value of an existing key. |
| `.pop()` | Removes a key:value pair from the dictionary and returns the value. |

### **Recap**

- A dictionary is a Python type containing a sequence of key:value items separated by commas, and in between curly brackets `{}`.
- The dictionary methods `.items()`, `.keys()`, and `.values()` are used to access items, keys, and values, respectively.
- To change a dictionary value, we overwrite the existing value using slicing.
- To add a new item, we use a slicing-like syntax or the method `.update()`.
- To delete an item, we use the keyword `del` or the method `.pop()`.

---

<!-- SUBSECTION -->

## Dictionaries with lists as values

In the previous Chapter, you learned about dictionaries and lists of dictionaries. In this Chapter, you will learn to code with dictionaries whose values are lists. 

- Your friend is planning a trip to Switzerland, and he has asked you for some tips. You start with an empty dictionary to fill out:

```python
1 tips = {}
```

We initialise an empty list by assigning curly brackets to the variable `tips` (line 1).

- He would like to visit some cities and taste typical food. Therefore, you add some recommendations:

```python
1 tips["cities"] = ["Bern", "Lucern"]
2 tips["food"] = ["chocolate", "raclette"]
3 print(tips)

```

Output:

```
{'cities': ['Bern', 'Lucern'], 'food': ['chocolate', 'raclette']}

```

We fill out the empty dictionary `tips` with two new items. The first item has the string `"cities"` as a key and the list `["Bern", "Lucern"]` as a value (line 1). The second item has the string `"food"` as a key and the list `["chocolate", "raclette"]` as a value (line 2). To check for correctness, we print the dictionary (line 3).

We want to add new elements to the two lists that are `tips`’s values. How do we go about doing so? Let’s see four possibilities, one in each of the next four cells. In the first two cells we will add a city, and in the last two cells we will add two types of food. In all cases, the command will be composed of two steps: 

1. extracting the value (i.e., the list) corresponding to a certain key, and 
2. adding the new element to the list.
- Because his stay is four days, you add two more cities and two more dishes:

```python
1 tips["cities"].append("Lugano")
2 print(tips)

```

Output:

```
{'cities': ['Bern', 'Lucern', 'Lugano'], 'food': ['chocolate', 'raclette']}

```

First, we slice the list from the dictionary—`tips["cities"]` is `["Bern", "Lucern"]`. Then, we add the new elements to the list using `.append()` (line 1). Finally, we print to check for correctness (line 2).

Let’s add the second city, that is, "`Geneva`":

```python
1 tips["cities"] += ["Geneva"]
2 print(tips)

```

Output:

```
{'cities': ['Bern', 'Lucern', 'Lugano', 'Geneva'], 'food': ['chocolate', 'raclette']}

```

Like above, we slice the list from the dictionary—`tips["cities"]` is now `["Bern", "Lucern", "Lugano"]`. Then, we use list concatenation as an alternative to the method `.append()`. As you might remember, when using list concatenation we must reassign the changed value to the variable. In this example, we combine assignment and concatenation with the `+=` operator—the extended command is `tips["cities"] = tips["cities"] + ["Geneva"]` (line 1). At line 2, we print `tips` to check the dictionary’s content.

Let’s now add the first type of food, which is "onion tarte":

```python
1 tips.get("food").append("onion tarte")
2 print(tips)

```

Output:

```
{'cities': ['Bern', 'Lucern', 'Lugano', 'Geneva'], 'food': ['chocolate', 'raclette', 'onion tarte']}

```

As an alternative to slicing, we can extract a value using the dictionary method `.get()`, which takes the corresponding key as an argument. In our case, `.get("food")` returns the list `["chocolate", "raclette"]`. Then, we add the new element (`"onion tarte"`) using the list method `.append()` (line 1). At the end of the cell, we print `tips` to check for correctness (line 2).

Finally, let’s add the second type of food, that is, "fondue":

```python
1 tips["food"] = tips.get("food") + ["fondue"]
2 print(tips)

```

Output:

```
{'cities': ['Bern', 'Lucern', 'Lugano', 'Geneva'], 'food': ['chocolate', 'raclette', 'onion tarte', 'fondue']}

```

Like above, we use the method `.get()` to extract the value corresponding to `"food"`, which is the list `["chocolate", "raclette", "onion tarte"]`. Then, we use concatenation to add the last element `"fondue"`. Note that in this case we cannot use the compact operator `+=` because we cannot reassign to `tips.get("food")`. We can only reassign the outcome to `tips["food"]` (line 1). Finally, we print the dictionary to check for correctness (line 2).

In summary, the four ways that we have to add an element to a list that is a value of a dictionary are 

1. Using slicing with `.get()` and `.append()`
2. Using slicing with `.get()` and list concatenation
3. Using dictionary method `.get()` and `.append()`
4. Using dictionary method `.get()` and list concatenation

When coding, you can choose to use only one way or to alternate several ways. But it is important to know all ways to understand code written by somebody else.

In the examples above, you might have noticed that reading the print of a dictionary can be hard when several keys and values are displayed in one long line. Let’s learn how to print a key:value pair per line to improve readability:

- You want to check that the dictionary is correct, so you print all items one by one:

```python
1 for k,v in tips.items():
2     print(k,v)

```

Output:

```
cities ['Bern', 'Lucern', 'Lugano', 'Geneva']
food ['chocolate', 'raclette', 'onion tarte', 'fondue']

```

We use a for loop through values with two variables `k`—for the keys—and `v`—for the values. The two names could be different, but conventionally we use the initial of the variable they represent. `k` and `v` simultaneously browse the dictionary items returned by the `.items()` method (line 1). At each iteration, we print the current key `k` with the corresponding value `v` (line 2). Note that `k` and `v` are separated by comma. This is independent from the fact that we are printing the items of a dictionary. The built-in function `print()` can take variables of different types separated by comma as an argument. For example, we can use `print ("The Swiss cities in the list are", 4)` as an alternative to `print ("The Swiss cities in the list are" + str(4))`.

What if we want to print only the keys or only the values? 

```python
1 for k in tips.keys():
2     print(k)

```

Output:

```
cities
food

```

In the for loop header, we use only the variable `k` in combination with the method `.keys()` (line 1), and we print `k` only (line 2). Similarly for the values:

```python
1 for v in tips.values():
2     print(v)

```

Output:

```
['Bern', 'Lucern', 'Lugano', 'Geneva']
['chocolate', 'raclette', 'onion tarte', 'fondue']

```

<!-- SUBSECTION -->

In the for loop header, we use only the variable `v` in combination with the method `.values()` (line 1), and we print `v` only (line 2).

Finally, let’s have a look at one more elegant way to print dictionaries:

- Finally, you improve the print for improved readability:

```python
1 for k,v in tips.items():
2     print("{:>6}: {}".format(k,v))

```

Output:

```
cities: ['Bern', 'Lucern', 'Lugano', 'Geneva']
  food: ['chocolate', 'raclette', 'onion tarte', 'fondue']

```

The for loop header is the same as in the cell above: `k` and `v` iteratively browse keys and values returned by `.items()` (line 1). The argument of the built-in function `print()` at line 2 looks a bit more complicated. 

There is a string—constituted by red characters in between quotes—followed by the string method `.format()`, which takes two arguments: `k` and `v`. The symbols in the string contain two pairs of curly brackets, one with the symbols `{:>6}`, and one empty `{}`. These pairs of curly brackets have nothing to do with dictionaries. They are placeholders for the arguments of the string method `.format()`. The first argument `k` will be printed at the place of `{:>6}` and the second argument `v` at the place of `{}`. What is the meaning of `{:>6}`? It is composed of three parts: 

1. the symbol `:` indicates to print the whole text; 
2. the symbol `>` specifies that the text is aligned to the right; and 
3. the symbol `6` indicates that the printing space is made of 6 characters—because "cities" has 6 characters. 

What about the colon between the two placeholders? It is simply the colon printed between each key and the corresponding value—e.g., `cities:` followed by the list. Finally, what is the function of the string method `.format()`? It formats the arguments and inserts them into the placeholders.

### **Recap**

- To initialise a dictionary, we use a pair of empty curly brackets `{}`.
- The dictionary method `.get()` takes a key as an argument and returns the corresponding value.
- There are at least 4 different ways to access and modify dictionary values that are lists, by combining:
    - Slicing or `.get()` to extract a list from a dictionary.
    - List operations (such as concatenation) or methods (e.g., `.append()`) to modify a list.
- We can use the for loop through values to browse items, keys, and values of a dictionary.
- The built-in function `print()` can take several variables as an argument:
    - Separated by comma, or
    - Using placeholders `{}` in combination with the string method `.format()`.

---

<!-- SUBSECTION -->

## What are dictionaries for?

In this Chapter, the final one dedicated to dictionaries, you will learn some typical situations where using dictionaries is very convenient. Try to solve each example by yourself before looking into the solution

### **Counting Elements**

Dictionaries are extremely convenient when we need to save occurrences, that is, the number of times something happens. Let’s understand what this means with the following example.

- Given the following string:

```python
1 greetings = "hello! how are you?"
```

- Create a dictionary where the keys are the letters of the alphabet found in the string, and the corresponding values are the number of times each letter is present. Write the code in two ways: (1) using if/else; and (2) using .get().
1. **Using if/else:**
    
    ```python
    1 letter_counter = {}
    2
    3 for letter in greetings:
    4     if letter not in letter_counter.keys():
    5         letter_counter[letter] = 1
    6     else:
    7         letter_counter[letter] += 1
    8
    9 for k,v in letter_counter.items():
    10    print(k,v)
    ```
    
    Output:
    
    ```
    h 2
    e 2
    l 2
    o 3
    ! 1
    w 1
    a 1
    r 1
    y 1
    u 1
    ? 1
    ```
    
    We start with an empty dictionary called `letter_counter` (line 1). We browse each character of the string `greetings` using a for loop through elements (line 3). Then, for each character, we check if it is a key of `letter_counter` and we act accordingly (lines 4–7). If the current character is not already a key of `letter_counter`, we add a new key:value pair, where the key is `letter`, and the value is 1 (line 5). If the current character is already a key in `letter_counter`, then we add 1 to the already existing corresponding value (line 7).

<!-- SUBSECTION -->

2. **Using .get():**
    
    ```python
    1 letter_counter = {}
    2
    3 for letter in greetings:
    4     letter_counter[letter] = letter_counter.get(letter, 0) + 1
    5
    6 for k,v in letter_counter.items():
    7     print(k,v)
    
    ```
    
    Output:
    
    ```
    h 2
    e 2
    l 2
    o 3
    ! 1
    w 1
    a 1
    r 1
    y 1
    u 1
    ? 1
    ```
    
    Similarly to the previous method, we start with the empty dictionary `letter_counter` (line 1) and continue with a for loop through elements (line 3). The four lines of code containing the if/else construct are replaced by one single line containing an assignment, the method `.get()`, and a sum (line 4). The method `.get()` contains two arguments, `letter` and `0`, and it acts as follows: if the key does not exist, `.get()` returns the second argument; if the key already exists, `.get()` returns the corresponding value.
    

### **Compressing Information**

Dictionaries are extremely convenient for compressing redundant information: for example, to store signals acquired by sensors over a long time. Think of a sensor used to detect vibrations in the case of an earthquake. Most of the time, the sensor just records zeros as there is no seismic event. However, when an earthquake occurs, the sensor registers a spike (or a group of spikes) whose magnitude is different from zero. Saving days and days of zeros in a list would require a significant amount of computer memory, and it would be somewhat pointless because the signal information is in the spikes. To reduce the amount of storage memory while keeping the information, we can use a dictionary. How would you do it? And how would you then go back from the dictionary to the original list?

- Given the following list:

```python
1 sparse_vector = [0, 0, 0, 1, 0, 7, 0, 0, 4, 0, 0, 0, 8, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0]

```

We start with a list called `sparse_vector`, containing many zeros and a few integers spread among the zeros.

- Convert it into a dictionary:

```python
1 # create the dictionary
2 sparse_dict = {}
3 for i in range(len(sparse_vector)):
4     if sparse_vector[i] != 0:
5         sparse_dict[i] = sparse_vector[i]
6
7 # save the list length
8 sparse_dict["length"] = len(sparse_vector)
9
10 # print
11 for k,v in sparse_dict.items():
12     print(k,v)

```

Output:

```
3 1
5 7
8 4
12 8
16 6
24 9
length 27

```

We start with an empty dictionary called `sparse_dict` (line 2). Then, we browse the list `sparse_vector` with a for loop through indices (line 3) to select and save the information—that is, the nonzero integers and their positions in the list. If the current list element `sparse_vector[i]` is not equal to zero (line 4), then we add a new item to the dictionary `sparse_dict`, where the key is the position of the element in the list (i) and the value is the current nonzero element (`sparse_vector[i]`) (line 5). After the loop, we save an item where the key is the string "length", and the value is the actual length of the list (line 8). Finally, we print each dictionary item with a for loop through elements to check the correctness of our code (lines 11–12).

- How do we get back to the sparse vector?

```python
1 # create a list of zeros
2 sparse_vector_back = [0] * sparse_dict["length"]
3
4 # add nonzero values
5 for k,v in sparse_dict.items():
6     if k != "length":
7         sparse_vector_back[k] = v
8
9 # print
10 print(sparse_vector_back)

```

Output:

```
[0, 0, 0, 1, 0, 7, 0, 0, 4, 0, 0, 0, 8, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0]

```

We start by creating a list of zeros called `sparse_vector_back` of the same length as the original list `sparse_vector`. To create `sparse_vector_back`, we use list replication, where we replicate a list containing a zero (`[0]`) for a number of times equal to the length of the original list—whose value we saved in correspondence with the key "length". Then, we overwrite the nonzero values into the list. With a for loop, we browse each key:value pair in the dictionary (line 5). If the current key is not equal to "length" (line 6), we assign the current value `v`, which represents the magnitude of a spike, to the list `sparse_vector_back` in position `k` (line 7). Finally, we print the list to check for correctness (line 10).

<!-- SUBSECTION -->

### **Sorting Dictionaries**

In this last example about dictionaries and their applications, we will learn how to sort dictionaries according to their keys or values. Consider a simplified city registry containing citizens’ names as keys and their ages as values. Officers might need to sort the registry according to names to send out letters, or according to age to distinguish the kids from the elderly. Let’s see how to do it!

- Given the following dictionary:

```python
1 registry = {"Shaili": 4, "Chris": 90, "Maria": 70}

```

- Sort the dictionary items according to their keys:

```python
1 # create a new dictionary
2 sorted_registry = {}
3
4 # sort the keys
5 sorted_keys = list(registry.keys())
6 sorted_keys.sort()
7
8 # fill out the new dictionary
9 for k in sorted_keys:
10    sorted_registry[k] = registry[k]
11
12 print(sorted_registry)
```

Output:

```
{'Chris': 90, 'Maria': 70, 'Shaili': 4}
```

We start with an empty dictionary called `sorted_registry` that will have the same content as `registry`, but the items will be sorted according to the keys (line 2). To sort the keys, we extract the keys using the dictionary method `.keys()` and then transform its output into a list using the built-in function `list()` (line 5). Then, we sort the obtained keys in alphabetical order using the list method `.sort()` (line 6). Finally, we browse the list of sorted keys using a for loop (line 9) to fill out `sorted_registry`. For each key `k`, we extract the corresponding value in `registry` and assign it to `sorted_registry` at key `k`.

- Sort the dictionary items according to their values:

```python
1 # create a new dictionary
2 sorted_registry = {}
3
4 # sort keys according to values
5 sorted_keys = sorted(registry, key=registry.get)
6
7 # fill out the new dictionary
8 for k in sorted_keys:
9     sorted_registry[k] = registry[k]
10
11 print(sorted_registry)
```

Output:

```
{'Shaili': 4, 'Maria': 70, 'Chris': 90}
```

To sort a dictionary according to values, we create an empty dictionary (line 2), sort the keys (line 5), fill out the empty dictionary using a for loop (line 8), and print to check for correctness (line 11). The difference is the way we sort the keys, that is, according to dictionary values. We use the built-in function `sorted()` (line 5), which takes two arguments: the dictionary whose keys we want to sort and the dictionary combined with the method `.get`.

### **Recap**

- Some typical examples of dictionary use include counting elements, compressing information, and sorting a dictionary according to keys and values.
- The dictionary method `.get(key, initial value)` is used to initialise a key:value pair in a dictionary and fill it up during a for loop.
- The built-in function `sorted()` is used to sort a dictionary; note that it creates a new variable.

---
<!-- SUBSECTION -->

## Strings: Operations, methods, and printing

In this chapter, we will summarize the characteristics of strings, similar to what we did for lists in Chapter 21. You’ll notice a lot of commonalities between the two data types, but also some important differences. Follow along with Notebook 27. As usual, try to solve the tasks before looking into the solution. Let’s start!

### **String Slicing**

String slicing works like list slicing. Take a look at the two examples below as a refresher.

- **Given the following string:**

```python
1 two_ways = "rsecwyadrkd"
```

We start with a string of characters. You might remember that in coding we use the word *characters* instead of *letters*.

- **Extract every second character:**

```python
2 print(two_ways[:,:,2])
```

Output:

```
reward
```

The start is the beginning of the string, so we can omit it. Similarly, the stop is the end of the string, so we can omit it too. The *step* is 2. The outcome is `reward` (line 1).

<!-- SUBSECTION -->

- **Extract every second character and invert the outcome:**

```python
3 print(two_ways[:,:,-2])
```

Output:

```
drawer
```

Print `two_ways` from the end to the beginning with a step of minus two → `drawer`.

Opposite to the above, the *start* is the end of the string, and the stop is the beginning of the string; therefore, we can omit both. Since we are going backwards, the step is `-2`.

(Did you know that the reverse of *reward* is *drawer*?)

### **“Arithmetic” Operations on Strings**

There are two “arithmetic” operations on strings: **concatenation** and **replication**. They follow the same principles as lists do. Let’s quickly look at a refresher on how they work.

- **Concatenate two strings:**

```python
4 first = "sun"
5 second = "screen"
6 combo = first + second
7 print(combo)
```

Output: 

```
sunscreen
```

`first` is assigned `"sun"` (line 4), `second` is assigned `"screen"` (line 5), and we merge them using the `+` operator to get `"sunscreen"` (line 6). We print the result (line 7).

- **Replicate a string 5 times:**

```python
8 one_smile = ":-)"
9 five_smiles = one_smile * 5
10 print(five_smiles)
```

Output:

```
:-):-):-):-):-)
```

`one_smile` is assigned a smiley face (line 8). We replicate it using the `*` operator and print the result (lines 9–10): `:-):-):-):-):-)`.

### **Replacing or removing substrings**

Substrings are parts of strings. In many of the following examples, we use substrings composed of only one character for simplicity. However, the rules also apply to substrings composed of multiple characters.

Let’s learn how to replace or remove substrings in a string based on a substring's **position** or **content**.

- Replace a Substring Based on Position

**Given the following string:**

```python
1 favorites = "I like cooking, my family, and my friends"

```

Output:

```
favorites is assigned "I like cooking, my family, and my friends"
```

We start with a string containing a sentence (line 1).

- **Attempt to replace the character at position 0 with "U" using slicing and assignment:**

```python
1 favorites[0] = "U"

```

Output:

```
TypeError: 'str' object does not support item assignment
```

Why do we get this error?

Because in Python, **strings are immutable**—they cannot be changed by assignment. To modify a string, we must use slicing combined with concatenation or string methods.

<!-- SUBSECTION -->

- **Redo the same task using slicing and concatenation:**

```python
1 from_position_one = favorites[1:]
2 favorites = "U" + from_position_one
3 print(favorites)

```

Output: 

```
U like cooking, my family, and my friends
```

Explanation:

- Line 1 slices the part of the string from position 1 to the end and assigns it to `from_position_one`.
- Line 2 concatenates `"U"` with that slice and reassigns it to `favorites`.
- Line 3 prints the result.

We could also write it as one line: `favorites = "U" + favorites[1:]`.

**Redo the same task using the `.split()` method:**

```python
1 favorites = "I like cooking, my family, and my friends"
2 parts = favorites.split("I")
3 print(parts)
4 favorites = "U" + parts[1]
5 print(favorites)

```

Output:

```
['', ' like cooking, my family, and my friends']
U like cooking, my family, and my friends

```

Explanation:

- Line 1 rewrites the original string since it was changed previously.
- Line 2 uses `.split("I")` to divide the string at `"I"`.
- Line 3 prints the resulting list: the first element is an empty string, and the second contains the rest of the sentence.
- Line 4 concatenates `"U"` with the second element.
- Line 5 prints the final result.

Another example:

If we split by `"cooking"`:

```python
parts = favorites.split("cooking")

```

Output:

```
['I like ', ', my family, and my friends']
```

Let’s now look at how to change a substring **based on its content**, not position.

- **Replace commas with semicolons using `.replace()`:**

```python
1 favorites = "I like cooking, my family, and my friends"
2 favorites = favorites.replace(",", ";")
3 print(favorites)

```

Output: 

```
I like cooking; my family; and my friends
```

Explanation:

- Line 1 rewrites the original string.
- Line 2 uses `.replace(",", ";")` to substitute commas with semicolons.
- Line 3 prints the result.

To **remove substrings based on position**, use slicing or `.split()` with concatenation.

**Example: remove `"cooking"` from the string:**

```python
favorites = favorites[:6] + favorites[15:]

```

Output: 

```
[I like my family, and my friends]
```

To **remove substrings based on content**, use `.replace()` with an empty string.

- **Remove all commas:**

```python
1 favorites = "I like cooking, my family, and my friends"
2 favorites = favorites.replace(",", "")
3 print(favorites)

```

Output: 

```
[I like cooking my family and my friends]
```

Explanation:

- Line 1 rewrites the original string.
- Line 2 removes commas by replacing them with an empty string.
- Line 3 prints the result.

<!-- SUBSECTION -->

### Searching a Substring in a String

How do we find a substring in a string? Let’s see below!

---

**Given the following string:**

```python
1 us = "we are"

```

Output:

```
favorites is assigned "we are"

```

We start with a short string named `us` (line 1).

**Find the positions of the character `e` using the method `.find()`:**

```python
1 positions = us.find("e")
2 print(positions)

```

Output:

```
1
```

We use the method `.find()` that takes the substring that we want to find as an argument—in our case, `"e"`.

We assign the outcome to the variable `positions` (line 1) and we print it (line 2).

Anything unexpected in the outcome?

We get only the position 1, whereas in `us`, `"e"` is at positions 1 and 5.

This happens because the method `.find()` returns only the position of the **first** substring that it finds.

- **Find the positions of the character `e` using an alternative way:**

```python
1 # initializing positions
2 positions = []

3 # find all positions of e
4 for i in range(len(us)):
5     if us[i] == "e":
6         positions.append(i)

7 print(positions)

```

Output:

```
[1, 5]
```

We initialize the variable `positions`—which will contain the positions of all the substrings `e`—as an empty list (line 2).

Then, we create a for loop through indices to browse all the positions in `us` (line 4).

If the character at the current position `i` is equal to `"e"` (line 5), then we append `i` to the list `positions` (line 6).

Finally, we print `positions` to check for correctness (line 7).

- **Find the positions of the character `f` using the method `.find()`:**

```python
1 positions = us.find("f")
2 print(positions)

```

Output:

```
-1
```

Similarly to the earlier example, we use the method `.find()` to look for the substring `"f"` in the string `us`,

and we assign the outcome to the variable `positions` (line 1).

Then, we print `positions` (line 2). The outcome is `-1`.

Thus, when we search for a substring that is not in the string, `.find()` returns `-1`.

This is a trick that is often used in conditions, such as:

```python
1 if us.find("f") == -1:
2     print("Character not found!")

```
<!-- SUBSECTION -->

### Counting the Number of Substrings in a String

- **Given the following string:**

```python
1 hobbies = "I like going to the movies, traveling, and singing"
```

We start with a string containing text about hobbies (line 1).

---

- **Count the number of substrings `"ing"` using the method `.count()`:**

```python
1 n_substrings = hobbies.count("ing")
2 print(n_substrings)
```

Output:

```
4
```

We use the method `.count()` which takes the substring whose occurrence we want to count—in our case `"ing"`—as an argument,

and we save the outcome in the variable `n_substrings` (line 1).

Then we print the result (line 2).

The substring is present **4 times**:

- going
- traveling
- singing
- (and possibly overlapping or concatenated ones in how Python counts)

<!-- SUBSECTION -->

### **String to List and Back**

It can be convenient to separate the words in a string into list elements or to merge strings that are elements of a list into a single string. Let’s see how to do both operations.

- **Given the following string:**

```python
1 string = "How are you"
```

`string` is assigned *How are you*

We start with a string containing three words: *How*, *are*, and *you* (line 1).

- **Transform the string into a list of strings where each element is a word:**

```python
1 list_of_strings = string.split()
2 print(list_of_strings)

```

Output:

```
['How', 'are', 'you']

```

Words are separated by spaces. Thus, we can use the method `.split(" ")` with a space as an argument. However, an empty string `" "` is the default argument for `.split()`, thus we can omit it—in other words, writing `.split()` is equivalent to writing `.split(" ")`. We assign the outcome to the variable `list_of_strings` (line 1), and we print it (line 2). As you can see, `list_of_strings` is a list containing three elements, each of them corresponding to one of the words in `string`.

How do we go back to a list? Let’s learn it in the next cell!

- **Transform the list of strings into a string using the method `.join()`:**

```python
1 string_from_list = " ".join(list_of_strings)
2 print(string_from_list)

```

Output:

```
How are you
```

The method `.join()` connects the elements of the list in the argument, separating them with the string it refers to. In our case, the list in the argument is `list_of_strings`, which contains the three strings "How", "are", and "you". The string to which `.join()` is applied is a space—that is, `" "` (line 1). The command might look peculiar at first because we apply the method directly to the string value `" ".join()`. As an alternative, we could assign the space to a variable—`space = " "`—and then apply the method to the variable—`space.join()`. To conclude the task, we print `list_of_strings` to check for correctness (line 2).

<!-- SUBSECTION -->

### Changing Character Cases

There are several options when changing character cases. Let’s have a quick look at them with the simple example below.

- **Given the following string:**

```python
1 greeting = "Hello! How are you?"

```

`greeting` is assigned *Hello! How are you?*

We start with a string where the first character of "Hello" and "How" are uppercase and all the other characters are lowercase.

- **Modify the string to uppercase and lowercase; change to uppercase only the first character of the string, and then each word of the string; finally, invert the cases:**

```python
1 # uppercase
2 print(greeting.upper())

3 # lowercase
4 print(greeting.lower())

5 # change the first character of the string to uppercase
6 print(greeting.capitalize())

7 # change the first character of each word to uppercase
8 print(greeting.title())

9 # invert cases
10 print(greeting.swapcase())

```

Output:

```
HELLO! HOW ARE YOU?
hello! how are you?
Hello! how are you?
Hello! How Are You?
hELLO! hOW ARE YOU?

```

To change the string to uppercase, we use the method `.upper()` (line 2).

To change the string to lowercase, we use `.lower()` (line 4).

To change to uppercase only the first character of the string, we use `.capitalize()` (line 6).

To change to uppercase the first characters of all the words, we use `.title()` (line 8).

Finally, to swap characters from uppercase to lowercase and vice versa, we use `.swapcase()` (line 10).

### Printing Variables

Printing is particularly useful in coding to check for correctness of operations and algorithms.

In previous chapters, we learned that the arguments of the built-in function `print()` can be:

1. Concatenated variables 
2. Variables separated by commas 
3. A string in combination with the method `.format()` 

We’ll now explore those and also f-strings and better ways to print numerical variables.

<!-- SUBSECTION -->

- **Given the following string:**

```python
1 part_of_day = "morning"

```

`part_of_day` is assigned *morning* (line 1)

- **Print `Good morning!` in 4 different ways:**

```python
1 # (1) string concatenation
2 print("Good " + part_of_day + "!")

3 # (2) variable separation by comma
4 print("Good", part_of_day, "!")

5 # (3) the method .format()
6 print("Good {}!".format(part_of_day))

7 # (4) f-strings
8 print(f"""Good {part_of_day}!""")

```

Output:

```
Good morning!
Good morning !
Good morning!
Good morning!
```

When using concatenation (line 2), make sure to include the space after "Good".

With comma separation (line 4), Python automatically adds spaces between arguments, which can lead to unwanted spacing.

With `.format()` (line 6), the variable is inserted into `{}`.

With f-strings (line 8), the variable is embedded directly within `{}` inside a string prefixed with `f`.

- **Given a string and a numerical variable:**

```python
1 part_of_day = "morning"
2 time_of_day = 10

```

We consider two variables:

- `part_of_day` — containing "morning" (line 1)
- `time_of_day` — containing the integer 10 (line 2)
- **Print `Good morning! It's 10a.m.` using the same four methods:**

```python
1 # (1) string concatenation
2 print("Good " + part_of_day + "!\nIt's " + str(time_of_day) + "a.m.")

3 # (2) variable separation by comma
4 print("Good", part_of_day, "!\nIt's", time_of_day, "a.m.")

5 # (3) the method .format()
6 print("Good {}!\nIt's {}a.m.".format(part_of_day, time_of_day))

7 # (4) f-strings
8 print(f"""Good {part_of_day}!
9 It's {time_of_day}a.m.""")

```

Output (all four lines):

```
Good morning!
It's 10a.m.
Good morning !
It's 10 a.m.
Good morning!
It's 10a.m.
Good morning!
It's 10a.m.

```

For concatenation (line 2), remember to convert `time_of_day` to a string and manage spaces manually.

With commas (line 4), you get automatic spaces between arguments.

With `.format()` (line 6), you plug variables into `{}`.

With f-strings (lines 8–9), you simply reference variables inside `{}` and format newlines directly in the string.

- **Given the numerical variable:**

```python
1 number = 1.2345

```

`number` is assigned *1.2345* (line 1)

- **Print `The number is 1.23` using the four methods above (with only 2 decimal places):**

```python
1 # (1) string concatenation
2 print("The number is " + str(round(number, 2)))

3 # (2) variable separation by comma
4 print("The number is", round(number, 2))

5 # (3) the method .format()
6 print("The number is {:.2f}".format(number))

7 # (4) f-strings
8 print(f"""The number is {number:.2f}""")

```

Output:

```
The number is 1.23
The number is 1.23
The number is 1.23
The number is 1.23

```

With concatenation or commas (lines 2–4), use `round(number, 2)` to limit to 2 decimal places.

With `.format()` (line 6), `{:.2f}` formats the float to 2 decimals.

F-strings (line 8) use the same format, just placed inside the `{}` directly.

<!-- SUBSECTION -->

### **Recap**

- In strings, slicing and the “arithmetic” operations (concatenation and replication) work the same  way as for lists
- Strings are immutable and thus assignment is not possible
- Strings have 47 methods. Of these, the 11 methods learned so far are:
    
    
    | **String Method** | **What it does** |
    | --- | --- |
    | `.capitalize()` | Converts the first character to uppercase and the rest to lowercase |
    | `.count()` | Returns the number of times a specified value occurs in the string |
    | `.find()` | Returns the index of the first occurrence of a specified value |
    | `.format()` | Formats a string by inserting variables into placeholders `{}` |
    | `.join()` | Joins elements of an iterable into a single string, using the string as a separator |
    | `.lower()` | Converts all characters in the string to lowercase |
    | `.replace()` | Replaces all occurrences of a specified value with another value |
    | `.split()` | Splits a string into a list using a specified separator (default is space) |
    | `.swapcase()` | Swaps uppercase characters to lowercase and vice versa |
    | `.title()` | Capitalizes the first character of each word in the string |
    | `.upper()` | Converts all characters in the string to uppercase |
- There are at least four ways to combine strings and numerical variables when printing: concatenation, comma separation, method `.format()`, and f-strings
- To round a number to a wanted number of decimals, we can use the built-in function `round()`
<!-- SUBSECTION -->
# Part 8. Functions

---

## Function Inputs

> A function is a block of code that accomplishes a specific task.
> 

Let’s explore how functions work by walking through an example.

### **Basic Thank You Cards**

- You recently hosted a party, and you want to send Thank you cards to those who attended. Create  a function that takes a first name as an argument and prints a Thank you message containing an  attendee’s name (e.g., Thank you Maria):

```python
1 def print_thank_you(first_name):
2     """
3     Prints a string containing "Thank you" and a first name
4
5     Parameters
6     ----------
7     first_name : string
8         First name of a person
9     """
10     print("Thank you", first_name)
```

Here, we define a function called `print_thank_you` that takes one input: `first_name`. This input is used to personalize a thank-you message.

- Print two Thank you cards:

```python
11 print_thank_you("Maria")
12 print_thank_you("Xiao")

```

Output:

```
Thank you Maria
Thank you Xiao

```

On lines 11 and 12, we call the function with specific arguments. The output displays a thank-you message for each person.

The string `"Maria"` is passed as an **argument** to the function. It will be assigned to the parameter `first_name`.

The function then executes the `print` command: `print("Thank you", first_name)`. This prints `"Thank you Maria"` because `first_name` now holds the value `"Maria"`.

A function definition has several parts:

1. **Header**: Starts with the keyword `def`, followed by the function name, parentheses with parameters, and ends with a colon `:`.
2. **Function Name**: Follows naming conventions (lowercase letters, underscores between words if needed).
    - The first thing that happens when you run this code is that the function `print_thank_you` is defined. However, it doesn't execute anything yet. The function is now available for use, but nothing happens until you call it.
3. **Parameters**: Input variables that are used within the function body.
    - **Parameter**: `first_name` (in the function definition). It's a placeholder for the value that will be passed in when calling the function.
4. **Docstring**: A triple double-quoted block that documents what the function does and describes each parameter.
5. **Body**: Indented code block that defines the actions of the function.

<!-- SUBSECTION -->

### **Formal Thank You Cards**

- After a second thought, you decide that it is more appropriate to print formal Thank you cards. Modify the previous function to take three arguments—prefix, first name, and last name—and to print  a thank you message containing them (e.g., Thank you Mrs Maria Lopez):

```python
1 def print_thank_you(prefix, first_name, last_name):
2     """
3     Prints a string containing "Thank you" and the inputs
4
5     Parameters
6     ----------
7     prefix : string
8         Usually Ms, Mrs, Mr
9     first_name : string
10         First name of a person
11     last_name : string
12         Last name of a person
13     """
14     print("Thank you", prefix, first_name, last_name)

```

- Print two formal Thank you cards:

```python
15 print_thank_you("Mrs", "Maria", "Lopez")
16 print_thank_you("Mr", "Xiao", "Li")

```

Output:

```
Thank you Mrs Maria Lopez
Thank you Mr Xiao Li

```

In this example, the function takes **three inputs** — `prefix`, `first_name`, and `last_name` — and combines them in a message.

- **Line 1**: The function `print_thank_you` is now defined to take **three parameters**: `prefix`, `first_name`, and `last_name`.
    - These parameters are separated by commas and will represent values that the function will use when called.
    - The order of the parameters matters; they are expected to be passed in the same order when calling the function.
- **Lines 2-13**: The **docstring** describes what the function does and provides details about each parameter:
    - **`prefix`**: A string that represents a prefix (e.g., Mr., Dr.).
    - **`first_name`**: A string that represents the first name of the person.
    - **`last_name`**: A string that represents the last name of the person.
    - The **parameters** are described in the same order they appear in the function header.
    - The docstring follows the **same syntax**: parameter name, type, and a brief description, with each parameter explained on two consecutive lines.
- **Line 14**: The function body contains one line of code that **prints a message** using all three parameters.
    - It combines the `prefix`, `first_name`, and `last_name` in the output, using an **f-string** for formatting. This prints something like `"Thank you Dr. John Doe"` based on the values passed when calling the function.
- **Line 15**: When calling the function, we need to pass **arguments** in the same order as the parameters are defined:
    - First, `"Dr."` for the `prefix` parameter.
    - Then, `"John"` for the `first_name` parameter.
    - Finally, `"Doe"` for the `last_name` parameter.

The function will now print:

```
Thank you Dr. John Doe

```
<!-- SUBSECTION -->

### **Default Argument**

- You are very happy with the Thank you cards, but you suddenly realize that some participants did  not provide their last names! Adapt the function so that the last name has an empty string as a  default value:
    
    Sometimes we may not want to specify all arguments. We can use **default arguments**:
    

```python
1 def print_thank_you(prefix, first_name, last_name=""):
2     """
3     Prints a string containing "Thank you" and the inputs
4
5     Parameters
6     ----------
7     prefix : string
8         Usually Ms, Mrs, Mr
9     first_name : string
10         First name of a person
11     last_name : string
12         Last name of a person. The default value is an empty string
13     """
14     print("Thank you", prefix, first_name, last_name)

```

Function Calls:

```python
15 print_thank_you("Mrs", "Maria", "Lopez")
16 print_thank_you("Mr", "Xiao")

```

Output:

```
Thank you Mrs Maria Lopez
Thank you Mr Xiao

```

In the function header, we assign a default value to the input that can be missed when calling the  function. In our case, we assign an empty string to the variable last_name (line 1). We call last_name  default parameter, and we specify the default value in its description in the docstrings (line 11).

If no value is provided for `last_name`, it defaults to an empty string. This makes the function more flexible.

<!-- SUBSECTION -->

### **Prefix and/or first name missing**

- Finally, you realize that prefix and/or first name are also missing for some guests. Modify the function accordingly:
    
    ```python
    1 def print_thank_you(prefix = "", first_name = "", last_name = ""):
       # def print thank you prefix is assigned empty string first name is assigned empty string last name is assigned empty string
    2 """Prints each input and a string concatenating "Thank you" and the inputs
       # Prints a string containing Thank you and the inputs
    3
    4 Parameters
    5 ---------
    6 prefix : string
       # prefix : string
    7 Usually Ms, Mrs, Mr. The default value is an empty string
       # Usually Ms, Mrs, Mr. The default value is an empty string
    8 first_name : string
       # first name : string
    9 First name of a person. The default value is an empty string
       # First name of a person. The default value is an empty string
    10 last_name : string
       # last name : string
    11 Last name of a person. The default value is an empty string
       # Last name of a person. The default value is an empty string
    12 """
    13
    14 print("Prefix:", prefix)
       # print Prefix: prefix
    15 print("First name:", first_name)
       # print First name: first name
    16 print("Last name:", last_name)
       # print Last name: last name
    17 print("Thank you", prefix, first_name, last_name)
       # print Thank you prefix first name last name
    
    ```
    
- Print a Thank you card where the first name is missing:

```python
1 print_thank_you(prefix = "Mrs", last_name = "Lopez")
```

Output:

```
Prefix: Mrs
First name:
Last name: Lopez
Thank you Mrs Lopez

```

- Print a Thank you card where the prefix is missing:

```python
1 print_thank_you(first_name = "Xiao", last_name = "Li")

```

Output:

```
Prefix:
First name: Xiao
Last name: Li
Thank you Xiao Li

```

In the function header, we assign a default value to each parameter—in our case, an empty string (line 1)—and we add this information to the docstrings (lines 7 and 11). In this example, we also print each parameter to clarify what happens when we call the function (lines 14–16), as you will see in a bit.

What about the function calls? When we call `print_thank_you` with the arguments `prefix="Mrs"` and `last_name="Lopez"` (cell 11), `first_name` is automatically assigned its default value, that is, an empty string—see the print from line 15. Similarly, when we call the function with the arguments `first_name="Xiao"` and `last_name="Li"` (cell 12), `prefix` is assigned the default empty string—see the print from line 14.

In addition, in the print `Thank you Mrs Lopez` (from line 17), there are two spaces between Mrs and Lopez. This occurs because when we print using comma separation, a space is automatically inserted between variables. Thus, one space separates Mrs and the first name—which is missing—and one space separates the first name and Lopez. In the same way, in the print `Thank you Xiao Li`, there is an extra space due to the absence of a prefix.

What if we want to be precise and ensure that there is one single space between the variables? We could write an if/elif/else construct like the following:

```python
1 if prefix == "":
2     print("Thank you", first_name, last_name)
3 elif first_name == "":
4     print("Thank you", prefix, last_name)
5 else:
6     print("Thank you", prefix, first_name)
```

Finally, do we always need to provide default values to the parameters in a function? Not necessarily, especially when there are no appropriate default values or when it’s essential that all arguments are specified when calling the function.

Why do we create functions?

At this point, you might wonder, why do we need to create functions? Can we not just write the `print()` command whenever we need it? The functions in cells 1, 4, and 7 contain only a single line of code, so writing a function might seem unnecessary. However, consider the function in cell 10. It has four lines of code, and if we want to reuse them in several cases , we have to keep copying and pasting. This can lead to errors and makes the code harder to maintain.

By creating a function, we encapsulate this logic in one place, allowing us to call it whenever needed without duplicating code. This not only saves time but also enhances readability and maintainability.

In addition, functions allow us to break down complex problems into smaller, manageable tasks. Each function can focus on a specific subtask, making it easier to understand and modify.

### **Recap**

- Functions are blocks of code that accomplish a specific task. They are crucial for code reuse and modularisation.
- A function comprises at least three components:
    - A header, which starts with the keyword `def`, followed by the name of the function, and round brackets containing the parameters separated by commas. Parameters can have default values.
    - Docstrings, which describe what the function does and its parameters.
    - Code that solves a task.
- To call a function, we write the function name followed by round brackets containing the arguments separated by commas.
- Parameters and arguments are function inputs. Technically, we call parameters the variables listed in the function header, and arguments the variables in the function call.
- Docstrings are fundamental when writing and using functions and can be accessed using the built-in function `help()`.

---

<!-- SUBSECTION -->

## Function outputs and modular design

In the previous Chapter, we learned about functions and their inputs. In this Chapter, we will dive into function outputs. In addition, we’ll take a look at designing and organizing multiple functions in a larger project. Let’s tackle all this by solving the following task.

- You are the owner of an online store and need to securely store the usernames and passwords of your customers. Create a database where usernames are composed of the initial of the customer’s first name followed by their last name (e.g., “jsmith”), and passwords consist of a four-digit code.

First, we have to create a database. A database is an organized collection of data that can be easily accessed and managed. Examples of databases include an inventory at a grocery store, a library catalog, or a phone contact list. In our case, the database will be a collection of customers’ usernames and passwords. In general, simple databases can be implemented as dictionaries.

How would you create this database, and how would you insert usernames and passwords? What variables would you use and of what types? How many functions would you write, and what would each function do? Take some time to think about your solution before proceeding to the next paragraph!

To solve our task, the first thing to do is to “divide and conquer” by defining what variables and functions we need to create. Let’s start with the variables and their data types. For each customer, we need two strings—one for the username and one for the password. We’ll save them in a dictionary—that is, a database—where the usernames will be the keys and the passwords will be the values. Let’s now think about how to modularize the code—that is, how to organize it into functions. We can write three functions: one to create a username, one to create a password, and one that calls the previous two functions and adds the created usernames and passwords to a database. Let’s take a closer look at how to implement this solution!

### Creating a username

Read the following text and code and try to deduce what the code does.

- Write a function that creates a username composed of the initial of the first name and the last name:

```python
1 def create_username(first_name, last_name):
   # def create username first name last name
2 """Creates a lowercase username made of initial of first name and full last name
   # Creates a lowercase username made of initial of first name and full last name
3
4 Parameters
5 ---------
6 first_name : string
   # first name : string
7 First name of a person
   # First name of a person
8 last_name : string
   # last name : string
9 Last name of a person
   # Last name of a person
10
11 Returns
12 ------
13 username : string
   # username : string
14 Created username
   # Created username
15 """
16
17 # concatenate initial of first name and last name
18 username = first_name[0] + last_name
   # username is assigned first name in position 0 concatenated with last name
19 # make sure the username is lowercase
20 username = username.lower()
21
22 # return username
23 return username
```

- Test the function for two customers:

```python
1 username_1 = create_username("Julia", "Smith")
2 print(username_1)
```

Output:

```
jsmith
```

```python
1 username_2 = create_username("Mohammed", "Seid")
2 print(username_2)
```

Output:

```
mseid
```

In cell 1, there is a function that creates a username. It takes two parameters—`first_name` and `last_name` (line 1)—which are used to create a username in two consecutive steps. First, we concatenate the initial of the first name—that is, `first_name` in position 0—with the last name, and we assign the result to the variable `username` (line 18). Then, we apply the method `.lower()` to `username` to ensure it is lowercase (line 20). What happens at line 23? We return `username`, meaning that we “push” `username` out of the function. Where does it go? Let’s look into the function calls. In the first line of cell 2, we call the function `create_username()` with the arguments `"Julia"` and `"Smith"`. The two arguments are automatically passed to the function header (cell 1, line 1). In the function, the first character of `"Julia"` and the whole string `"Smith"` are concatenated into `"JSmith"` and saved in the variable `username` (line 18). In the following command, `username` is modified to lowercase and becomes `"jsmith"` (line 20). At the end of the function, we return `username` (line 23)—that is, `"jsmith"` is sent out of the function—and we assign it to the variable `username_1` (cell 2, line 1). Finally, we print `username_1` (cell 2, line 2). Similarly, in the second function call (cell 3, line 1), we pass the arguments `"Mohammed"` and `"Seid"` to the function `create_username()` (cell 1, line 1), where the username `"mseid"` is created (lines 18 and 20). The username is returned (line 23) to be assigned to the variable `username_2` (cell 3, line 1) and then printed (cell 3, line 2). As above, we use `return` to send a variable from a function body back to the function call. You can see the path of the output variables in Figure 8.1.

![Figure 8.1. Path of a function output.](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%206.png)

Figure 8.1. Path of a function output.

### 

As is now clear, `return` is the keyword we use to transfer output variables from the function body to the function call. But it has another important property: it marks the end of a function. This means that any line of code written after `return` will never be executed! You might have realized that you have already used numerous returned variables throughout our learning journey. For example, the Python built-in function `int(14.45)` returns `14`, which means that in the function `int()`, the last line of code is something similar to `return integer_number`. Similarly, the method `.lower()` applied to the string `"JSmith"` returns `"jsmith"` because the last line of code is something similar to `return lower_case_string`.

Finally, let’s have a look at the documentation of the function in cell 1. As you can see, we specify the returned variables (lines 11–14). The syntax is the same as for the Parameters (lines 4–9). First, we write `Returns` as a title (line 11), followed by a series of minus signs that act as an underline (line 12). Then, for each returned variable—in this example, there is only one—we write (1) variable name (e.g., `username`), (2) space, (3) colon, (4) space, and (5) type (e.g., `string`) (line 13). On the following line, indented, we write the definition of the returned variable (line 14).

<!-- SUBSECTION -->

### Creating a password
We need to implement a function that creates a password composed of four integers.

- Write a function that creates a password composed of four random integers:

```python
1 import random
2
3 def create_password():
4 """Create a password composed of four random integers
   # Create a password composed of four random integers
5
6 Returns
7 ------
8 password : string
   # password : string
9 Created password
   # Created password
10 """
11
12 # create a random number with four digits
13 password = str(random.randint(1000, 9999))
   # password is assigned str random dot randint 1000 9999
14
15 # return password
16 return password
```

- Test the function for two customers

```python
1 password_1 = create_password()
2 print(password_1)
```

Output:

```
4883
```

```python
1 password_2 = create_password()
2 print(password_2)
```

Output:

```
5005

```

To generate a password with four integers, we’ll use a simple trick: we create a random number between `1000` and `9999`, which is the range of all the existing numbers with four digits! Then, we transform the obtained number into a string—using the built-in function `str()`—and we assign the result to the variable `password` (cell 4, line 13). Why are we converting the four-digit integer into a string? Because a password does not have any numerical meaning—that is, we do not use it in arithmetic operations such as addition or multiplication. Finally, we return `password` at line 16. Note that this function does not have any inputs. Thus, there are no parameters in between the round brackets in the header (line 3), there is no Parameters session in the documentation (lines 4–10), and we do not write any arguments in between the round brackets when we call the function (cells 5 and 6, line 1). The returned variable `password` (cell 4, line 16) is saved as `password_1` and `password_2`, at line 1 of cells 5 and 6, respectively. Finally, we print the passwords to check for correctness (cells 5 and 6, line 2).

<!-- SUBSECTION -->

### Creating a database

- Write a function that, given a list of lists of customers, creates and returns a database—i.e., a dictionary—of usernames and passwords. The function also returns the number of customers in the database:

```python
1 def create_database(customers):
2 """Creates a database as a dictionary with usernames as keys and passwords as values
   # Creates a database as a dictionary with usernames as keys and passwords as values
3
4 Parameters
5 ---------
6 customers : list of lists
   # customers : list of lists
7 Each sublist contains first name and last name of a customer
   # Each sublist contains first name and last name of a customer
8
9 Returns
10 ------
11 db : dictionary
   # db : dictionary
12 Created database (shorted as db)
   # Created database (shorted as db)
13 n_customers : int
   # n customers : int
14 Number of customers in the database
   # Number of customers in the database
15 """
16
17 # initialize dictionary (i.e. database)
18 db = {}
19
20 # for each customer
21 for customer in customers:
22
23 # create username
24 username = create_username(customer[0], customer[1])
25
26 # create password
27 password = create_password()
28
29 # add username and password to db
30 db[username] = password
31
32 # compute number of customers
33 n_customers = len(db)
34
35 # return dictionary and its length
36 return db, n_customers

```

Let’s analyze the function before calling it in the cells below. Let’s begin with the input and the outputs. The input is a variable called `customers`, as we can see in the function header (line 1). From the documentation, we learn that `customers` is a list of lists where each sublist contains a first name and a last name (lines 6–7). The outputs are two variables called `db` and `n_customers`, as we can see in the last line of the function after the keyword `return` (line 36). From the documentation, we learn that `db` is a dictionary that will contain the database (lines 11–12), whereas `n_customers` is an integer that will store the number of customers in the database (lines 13–14).

Let’s continue with the analysis of the function body. We initialize the variable `db` as an empty dictionary (line 18), which we will fill out within the function and eventually return. Then, for each customer in the list of lists (line 21), we perform three actions. First, we create a username by calling the function `create_username()` that we wrote in cell 1. The inputs are the first name—`customer[0]`—and the last name—`customer[1]`—of the current customer. We save the output in the variable `username` (line 24). Then, we create the password by calling the function `create_password()` from cell 4, and we save the output in the variable `password` (line 27). Finally, we add the username and the password to the database by assigning the variable `password` as a value to the corresponding key `username` in the database `db` (line 30). Once we complete the creation of username and password for each customer and exit the loop, we calculate the number of customers, which corresponds to the length of the dictionary. We use the built-in function `len()`, and we save the output in the variable `n_customers` (line 33). Finally, we return both `db` and `n_customers` (line 36). As you can see, to return multiple variables, we write them after the keyword `return` and separated by commas.

It is always very important to test the correctness of a function by calling it. So let’s call the function and test its behavior.

- Given the following list of customers:

```python
1 customers = [["Maria", "Lopez"], ["Julia", "Smith"], ["Mohammed", "Seid"]]
```

We create a list of lists called customers that contains three sublists.

- Create the database using two different syntaxes:

```python
1 # create the database - separate returns
2 database, number_customers = create_database(customers)
3
4 # print the outputs
5 print("Database:", database)
6 print("Number of customers:", number_customers)

```

Output:

```
Database: {'mlopez': '7097', 'jsmith': '6891', 'mseid': '3189'}
Number of customers: 3

```

When returning multiple outputs, there are two possible syntaxes for a function call. In this first case (cell 9), we create two output variables separated by a comma (line 2). The first variable `database` contains the returned variable `db` from cell 7, line 36. When we print it at line 5, we see the dictionary containing usernames and passwords for each customer. Similarly, the second variable `number_customers` contains the returned variable `n_customers` (cell 7, line 36). When we print `number_customers` at line 6, we see the dictionary length, which is `3`.

Let’s look at the other possible syntax for the outputs.

```python
1 # create the database - single return
2 outputs = create_database(customers)
3 print("Output tuple:", outputs)
4
5 # get and print the database
6 database = outputs[0]
7 print("Database:", database)
8
9 # get and print the number of customers
10 number_customers = outputs[1]
11 print("Number of customers:", number_customers)
```

Output:

```
Output tuple: ({'mlopez': '6350', 'jsmith': '7863', 'mseid': '1953'}, 3)
Database: {'mlopez': '6350', 'jsmith': '7863', 'mseid': '1953'}
Number of customers: 3
```

In this second case, we assign both returned variables to a single variable called outputs (line 2). As we can see from the print (line 3), outputs is a tuple that contains the database and the number of customers. As you might recall from Chapter 22, a tuple is a sequence of elements separated by commas and contained within round brackets. Tuple elements are immutable, which means that we cannot overwrite, add, or delete any element. However, we can extract the elements by using the same slicing principles that we learned for lists and strings. Thus, to get the dictionary, we slice outputs in position 0 (line 6), and we print it as a check (line 7). Similarly, to get the number of customers, we slice outputs in position 1 (line 10) and print it as a check (line 11). Obviously, we could have directly printed the sliced variable in both cases—that is, print("Database:", outputs[0]) and print("Number of customers:", outputs[1]).

![Figure 8.2. Modular organisation of code: Main and satellite functions.](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%207.png)

Figure 8.2. Modular organisation of code: Main and satellite functions.

Before concluding this Chapter, let’s briefly analyze how we modularized our code with the help of Figure 8.2. We created three functions, each of them with a different role. The function `create_database()`—on the left side of Figure 8.2—is the main function because it 

1. receives the input for the task to solve—a list of customer first names and last names; 
2. performs the flow of operations needed to solve the task—that is, it creates the database of usernames and passwords; and 
3. provides the final output—that is, it returns the dictionary and the number of customers. 

In some coding examples outside this book, you may find that the main function is actually called `main()`. The other two functions—`create_username()` and `create_password()`—are satellite functions because each of them performs one specific task. How do the main function and satellite functions interact? Through the flow of inputs and outputs. The main function sends inputs to the satellite functions—in our case, `first_name` and `last_name` are sent to `create_username()`—and receives outputs—`username` from `create_username()` and `password` from `create_password()`. The received outputs can then be used to create new variables such as the dictionary `db` in our example—or as inputs for subsequent satellite functions, as you will see in the coding exercise at the end of the Chapter.

### **Recap**

- The keyword `return` has two roles:
    - It transfers output variables from the function body to the function call. When multiple variables are returned, they are separated by commas both in the function body and in the function call. In the latter, they can also be collected into a tuple.
    - It marks the end of a function. Commands written after `return` do not get executed.
- Tuples are a data type where elements are immutable, meaning they cannot be changed. Tuple slicing follows the same rules as list (or string) slicing.
- In docstrings, the syntax of returned variables is the same as the syntax of input parameters.
- It is important to test function correctness by calling them with appropriate arguments.
- A project is often composed of a main function and some satellite functions. The main function executes the solution to the whole task, whereas each satellite function executes one specific subtask.

---

<!-- SUBSECTION -->

## Input Validation and Output Variations

What happens if we provide wrong inputs to a function? Sometimes the function breaks—meaning we get an error—and other times we get a meaningless result. In both cases, it might be difficult to understand what went wrong. In this chapter, we will learn how to ensure that function inputs are of the right type and value. In addition, we will also learn how to return outputs in specific cases, that is, based on conditions or directly as values. Let’s tackle all this through the example below. Follow along with Notebook 30!

- You work at a museum and have to update the online system to buy tickets. The update is that people who are 65 and older now qualify for a free ticket. Write a function that asks visitors to enter their prefix, last name, and age; checks the types and values of these inputs; and returns a message telling the visitor if they are eligible for a free ticket.

```python
1  def free_museum_ticket(prefix, last_name, age):
2      """Returns a message containing inputs and free ticket eligibility based on age.
3      E.g. Mrs. Holmes, you are eligible for a free museum ticket because you are 66.
4      
5      Parameters
6      ----------
7      prefix : string
8          Ms, Mrs, Mr
9      last_name : string
10         Last name of a visitor
11     age : integer
12         Age of a visitor
13     
14     Returns
15     -------
16     string
17          Message containing inputs and eligibility
18    """
19     
20     # --- checking parameter types --- 
21
22     # the type of prefix must be string
23     if not isinstance(prefix, str):
24         raise TypeError("prefix must be a string")
25     
26     # the type of last_name must be string
27     if not isinstance(last_name, str):
28         raise TypeError("last_name must be a string")
29
30     # the type of age must be integer   
31     if not isinstance(age, int):
32         raise TypeError("age must be an integer")
33
34
35     # --- checking parameter values --- 
36 
37     # prefix must be Ms, Mrs, or Mr     
38     if prefix not in ["Ms", "Mrs", "Mr"]:
39         raise ValueError("prefix must be Ms, Mrs, or Mr")
40
41     # last_name must contain only characters     
42     if not last_name.isalpha():
43        raise ValueError("last_name must contain only letters")
44
45     # age has to be between 0 and 125     
46     if age < 0 or age > 125:
47         raise ValueError("age must be between 0 and 125")
48   
49
50     # --- returning output ---
51 
52     if age >= 65:
53         return prefix + ". " + last_name + ", you are eligible for a free museum ticket because you are " + str(age)
54     else:
55         return prefix + ". " + last_name + ", you are not eligible for a free museum ticket because you are " + str(age)
```

Let’s begin to analyze the function by taking a look at what it does. In the docstring description, we see that the aim of `free_museum_ticket()` is to return a message composed of a concatenation of the inputs and the eligibility for a free ticket based on age (line 2). The description is followed by a message example for further clarification (line 3). Adding an example is good practice to make the function outcome more quickly and easily understood.

Let’s continue by looking at the inputs. The function has 3 parameters: `prefix`, `last_name`, and `age` (line 1), whose types and values are described in the documentation (lines 5–12) and further checked in the first 6 blocks of code (lines 20–47). The blocks have a similar structure, composed of an if condition followed by a raise statement.

The first three blocks check the parameter types (lines 20–32). In the first block (lines 22–24), we check if the first parameter `prefix` is a string. To do so, we write an if condition (line 23) composed of 

1. the keyword `if`, 
2. the logical operator `not`, and 
3. the built-in function `isinstance()`, which checks if a variable is of a specific type. It takes 2 parameters: the variable to check—`prefix`—and the wanted type—that is, `str`. Other possibilities for type are `int`, `list`, `dict`, etc. Types are not followed by round brackets and should not be confused with the built-in functions `str()`, `int()`, etc.

The function `isinstance()` returns a Boolean, that is, `True` if the variable is of the desired type—e.g., if `prefix` is a `str`—and `False` otherwise. Why do we use the logical operator `not` in the if condition? To make the condition true when we want it to be executed. In Boolean terms, we can say that if `prefix` is not a string, then the command `if not isinstance()` becomes `if not False`, which is the same as `if True` , and thus the following statement gets executed. The statement is composed of 

1. the keyword `raise`, which stops the function, and 
2. the built-in exception `TypeError()`, which specifies the nature of the error—type—and provides a message indicating what must be done to avoid the error (line 24).

To see the effect of these lines of code, let’s call the function using the wrong type for `prefix` and analyze what happens.

```python
1  # checking prefix type
2  message = free_museum_ticket(1, "Holmes", 66) 
3  print(message)  

```

Output:

```python
TypeError Traceback (most recent call last)
Cell In[2], line 2
  1  # checking prefix type
> 2 message = free_museum_ticket(1, "Holmes", 66)
  3 print(message)
Cell In[1], line 24, in free_museum_ticket(prefix, last_name, age)
  20 # --- checking parameter types ---
  21
  22 if not isinstance(prefix, str):
> 24 raise TypeError("prefix must be a string")
  25
  26 # the type of last_name must be string 
  27 if not isinstance (last_name, str):  
TypeError: prefix must be a strin
```

We use `1` for `prefix`—that is, an integer instead of a string—and correct types for `last_name`—a string—and `age`—an integer—to test one parameter at a time (line 2). We assign the function output to the variable `message`, and we print it (line 3). We get an error message.

Let’s dig deeper! As usual, we start from the last line. Here, we read the type of exception—`TypeError()`—and the string we wrote as an argument—`prefix must be a string`.

Let’s complete the analysis of the error message by looking at the arrows pointing at specific lines of code. The top arrow points at line 2 of cell 2, telling us where the error happens in the current cell—that is, where we called the function. The second arrow points at line 24 of cell 1, which is where the error originated, that is, where we raised the `TypeError()`. Note that since the error happens at cell 2 and thus the code stops, we do not see any print because the command at line 3 is not executed.

Let’s continue by checking the type of the second parameter `last_name` (lines 26–28). As for `prefix`, `last_name` must be a string. Thus, we simply reuse the commands at lines 23–24, substituting `prefix` with `last_name` in the if statement (line 27) and in the `TypeError()` message (line 28). Let’s test whether the type error works by calling the function with the wrong type for `last_name`—starting from this cell, only the relevant part of the error message is reported for brevity.

```python
1  # checking last_name type
2  message = free_museum_ticket("Mrs", 1.2, 66)
3  print(message)

```

Output:

```python
Cell In[3], line 2
> 2 message = free_museum_ticket("Mrs", 1.2, 66)
Cell In[1], line 28, in free_museum_ticket(prefix, last_name, age)
  27 if not isinstance(last_name, str):
> 28 raise TypeError("last_name must be a string")
TypeError: last_name must be a string
```

As expected, in the last line of the message, we get `TypeError: last_name must be a string`, which is the error that occurred at line 2 of the current cell and originated at line 28 of cell 1.

Let’s conclude the check of the parameter types with `age` (lines 30–32). In this case, the parameter must be an integer, not a string. Thus, in the built-in function `isinstance()`, the two inputs are the variable `age` and the type `int` (line 31). In `TypeError()`, the message becomes `age must be an integer` (line 32). Let’s test the correctness of this code with the following function call.

```python
1  # checking age type
2  message = free_museum_ticket("Mrs", "Holmes", "Hi")
3  print(message)

```

Output:

```python
Cell In[4], line 2
> 2 message = free_museum_ticket("Mrs", "Holmes", "Hi")
Cell In[1], line 32, in free_museum_ticket(prefix, last_name, age)
  31 if not isinstance(age, int):
> 32 raise TypeError("age must be an integer")
TypeError: age must be an integre
```

We enter the string `"Hi"` as the third parameter. As expected, the error occurs at line 2 of cell 4 and originated at line 32 of cell 1.

The following three blocks of code of `free_museum_ticket()` check the parameter values (lines 35–47). Similarly to before, each block contains an if construct composed of an if condition and a statement raising an exception. In the condition, we assess the parameter values by establishing some criteria specific to the context of the task. For example, for `prefix`, we establish that the possible values are `"Ms"`, `"Mrs"`, or `"Mr"`. Thus, we enclose the three strings into a list, and we check if the value of `prefix` is in that list (line 38). If not, we raise a `ValueError()` in the following statement (line 39).

`ValueError()` is the exception specific for value errors, and it works the same way as `TypeError()`. Within the round brackets, we write a message indicating what must be done to avoid the error—in our case, `prefix must be Ms, Mrs, or Mr`. Let’s check what happens when raising the value error for `prefix` in the following function call.

```python
[5]:
1  # checking prefix value
2  message = free_museum_ticket("Dr", "Holmes", 66)  # message is assigned free museum ticket Dr Holmes 66
3  print(message)  # print message

```

Output:

```python
Cell In[5], line 2
> 2 message = free_museum_ticket("Dr", "Holmes", 66)
Cell In[1], line 39, in free_museum_ticket(prefix, last_name, age)
  38 if prefix not in ["Ms", "Mrs", "Mr"]:
> 39 raise ValueError("prefix must be Ms, Mrs, or Mr")
ValueError: prefix must be Ms, Mrs, or Mr
```

For `prefix`, we use `" Dr"`, which is not in the list of possible values, `["Ms", "Mrs", "Mr"]`. Thus, we get a value error, as the message in the last line specifies. The error happens at line 2 of cell 5 and originated at line 39 of cell 1, as we can see from the two arrows in the pink area.

Let’s continue with checking the possible values for `last_name`. What condition should we use? Should we list all the possible last names in the world? What if some are not registered or new? In cases like this, we can look into the types of characters composing the string. For last names, we can require that all the characters are letters of the alphabet and, to do so, we can use the string method `.isalpha()` (line 42)—for simplicity, we’ll consider only last names composed of characters and not containing punctuation, such as O’Connor, or a space, such as García Lopez. In other contexts, we can perform the check using methods such as `.isalpha()`, `.isdigit()`, `.isalnum()`, `.islower()`, `.isupper()`, `.istitle()`—see Chapter 27—depending on the characteristics that the string must have.

If the condition is not met, then we raise a value error saying that the last name must contain only letters (line 43). Let’s test the execution of these two lines of code by calling the function with an incorrect value for `last_name`.

```python
1  # checking last_name value
2  message = free_museum_ticket("Mrs", "82", 66) 
3  print(message)

```

Output:

```python
Cell In[6], line 2
> 2 message = free_museum_ticket("Mrs", "82", 66)
Cell In[1], line 43, in free_museum_ticket(prefix, last_name, age)
  42 if not last_name.isalpha():
> 43 raise ValueError("last_name must contain only letters")
ValueError: last_name must contain only letters
```

In the function call (line 2), we use the string `"82"` for `last_name`. We get the value error with the message that we entered at line 43 in cell 1.

Let’s finally check the value of the last parameter `age`. What constraint should we use this time? One reasonable option is to raise a value error if `age` is not within the range of a human lifetime. How do we define the range? The minimum is obviously 0 years old. What about the maximum? According to Wikipedia, the oldest person ever was Jeanne Calment who died when she was 122 years and 164 days old! So, we can keep a bit of margin and define 125 as the maximum. Therefore, we check if `age` is less than 0 or greater than 125 (line 46). If so, we raise the `ValueError()` with the message suggesting the proper age range to use (line 47). Let’s test these commands by calling the function with an age out of range!

```python
1  # checking age value
2  message = free_museum_ticket("Mrs", "Holmes", 130)
3  print(message)

```

Output:

```python
Cell In[7], line 2
> 2 message = free_museum_ticket("Mrs", "Holmes", 130)
Cell In[1], line 47, in free_museum_ticket(prefix, last_name, age)
  46 if age < 0 or age > 125:
> 47 raise ValueError("age must be between 0 and 125")
ValueError: age must be between 0 and 125
```

In the function call (line 2), we provide the integer `130` for the parameter `age`, and we get the value error that we created at line 47 of the function, as expected.

At this point, you might ask yourself: do I have to implement the input check in every function I write? Nope! In Python, we assume that the docstrings clearly indicate the expected type and value of the parameters and that a coder passes valid arguments to a function. So, why did we learn it? Because a parameter check is useful in main functions or when there are user-provided inputs—for example, when using the built-in function `input()`, as you will see in the coding exercise at the end of this chapter.

Let’s conclude by analyzing the returns. In `free_museum_ticket()`, we return different outputs based on conditions (lines 50–55). To do that, we use an if/else construct where each statement contains the keyword `return`. If the age of the visitor is greater than or equal to 65 (lines 52), then we return the string indicating the eligibility for a free ticket (line 53); otherwise (line 54), we return a string indicating the ineligibility for a free ticket (line 55). As you might remember from the previous chapter, `return` not only “pushes” the variable out of a function, but it also stops the function. Thus, any command following the executed `return` statement (line 53 or 55) will never be executed.

In this function, we also directly return a value without creating an intermediate variable—this can be done in any function. In other words, we do not create a variable called `message` to which we assign the concatenation `prefix + ". " + last_name + ", you are eligible for a free museum ticket because you are " + str(age)`, and then return it as `return message`. We directly return the concatenation. Note that in the docstrings we only indicate the type—string—as there is no variable name (line 16).

Let’s conclude by calling the functions with the correct input types and values to test the correctness of the two returns.

```python
1  # person is eligible
2  message = free_museum_ticket("Mrs", "Holmes", 66)
3  print(message)

```

Output:

```
Mrs. Holmes, you are eligible for a free museum ticket because you are 66

```

```python
1  # person is not eligible
2  message = free_museum_ticket("Mrs", "Choi", 38)
3  print(message)

```

Output:

```
Mrs. Choi, you are not eligible for a free museum ticket because you are 38

```

In both cells, the inputs pass the type and value checks, thus the function executes the code and returns a message according to age. In the first case (cell 8), the age is 66 (line 2)—which is greater than 65—so the visitor is eligible for a free ticket. In the second case (cell 9), the age is 38 (line 2)—which is less than 65—so the visitor is not eligible for a free ticket.

<!-- SUBSECTION -->

### **Recap**

- Definitions
    
    
    | Name | Definition |
    | --- | --- |
    | `raise` | Keyword — used to trigger exceptions |
    | `TypeError()` | Exception — error type for invalid operations between types |
    | `ValueError()` | Exception — error type for invalid values |
    | `int` | Type — represents whole numbers |
    | `int()` | Built-in Function — converts values to integers |
    | `isinstance()` | Built-in Function — checks a variable's type |
- We implement parameter checks in main functions or in the presence of external inputs. The check is executed using an if/else construct. In the if condition:
    - When checking a type, we use the logical operator `not` followed by the built-in function `isinstance()`, whose parameters are the variable to check and the wanted type. Possible types are `str`, `int`, `list`, `dict`, etc.
    - When checking a value, we have to define constraints. We can use membership to a list, variable methods—such as `.isalpha()` for strings—or intervals for numbers.
- In the statement, we use `raise` followed by the exception `TypeError()` or `ValueError()` with a message indicating how to avoid the error.
- When we want to return different outputs based on conditions, we can use an if/else construct where the statements contain the keyword `return` followed by the wanted output.
- It is possible to return values instead of variables. In this case, in the docstrings, we indicate only the type.
- In docstrings, it is possible to write an example after the function definition to enhance clarity.

---

<!-- SUBSECTION -->

## **Recursive Functions**

In this chapter, you will learn a particular type of function called recursive functions. They can be challenging to understand and implement, but they are very useful in certain situations, as you will see.

To better understand how recursive functions work, let’s compute factorials. Have you ever heard of them? A factorial is the product of all positive integers that are less than or equal to a given positive integer. For example, the factorial of 4 is 24, calculated as$1 \times 2 \times 3 \times 4$ — or $4 \times 3 \times 2 \times 1$. How would you write a function that calculates the factorial of an integer? Write your own function before looking at the proposed solution below. 

- Write a function that calculates the factorial of a given integer using a for loop:

```python
1  def factorial_for(n):
2      """Calculates the factorial of a given integer using a for loop.
3      
4      Parameters
5      ----------
6      n : integer
7          The input integer
8      
9      Returns
10     -------
11     factorial : integer
12         The factorial of the input integer
13     """
14     
15     # initialize the result to one
16     factorial = 1
17     
18     # for each integer between 2 and the input integer
19     for i in range(2, n + 1):
20         # multiply the current result by the current integer
21         factorial *= i
22     
23     # return the result
24     return factorial
25 
26 # call the function
27 fact = factorial_for(4)
28 print(fact)  # Output: 24

```

- Compare the previous iterative function with the following recursive function:

```python
1  def factorial_rec(n):
2      """Calculates the factorial of a given integer using recursion.
3
4      Parameters
5      ----------
6      n : integer
7          The input integer
8
9      Returns
10     -------
11     integer
12         The factorial of the input integer
13     """
14
15     # if integer is greater than 1
16     if n > 1:
17         # execute the recursion
18         return factorial_rec(n - 1) * n
19     # otherwise
20     else:
21         # return 1
22         return 1
23
24 # call the function
25 fact = factorial_rec(4)
26 print(fact)  # Output: 24
```

Let’s start by analyzing the function `factorial_for()` in cell 1. In the docstrings, we see that the input is an integer called `n` (lines 4–7) and the output is another integer called `factorial` (lines 9–12). In the function body, we first initialize the output `factorial` to 1 (line 16). Then, we create a for loop where the index `i` will be assigned all the consecutive numbers from 2 to the input number `n + 1` (line 19)—do you remember the plus one rule for the stop in `range()` from Chapter 8? Within the loop, we calculate the product between the current value of `factorial` and the current value of `i`, and we reassign the result to `factorial` (line 21).

Let’s quickly go through the three iterations for more clarity:

- In the first iteration, `factorial` is 1 and `i` is 2, so the result of `factorial * i`—that is, 1 * 2—is 2, which is reassigned to `factorial`.
- In the second iteration, `factorial` is 2 and `i` is 3, so the result of `factorial * i`—that is, 2 * 3—is 6, which is reassigned to `factorial`.
- In the third iteration, `factorial` is 6 and `i` is 4, so the result of `factorial * i`—that is, 6 * 4—is 24, which is reassigned to `factorial`—and is the final value.

We conclude the function by returning `factorial` (line 24). To test the function, we call it with the number 4 as an input, and we assign the returned value to the variable `fact`  (line 27), which we print in the following command (line 28). Note that a function code and call can be in the same cell for convenience. In general, we call functions like `factorial_for()` iterative functions because they contain a loop to repeat some parts of their code.

Let’s now move to the recursive function `factorial_rec()` (cell 2) and identify similarities and differences with `factorial_for()` (cell 1). From the docstrings, we see that the function takes an integer `n` as an input (lines 4–7)—similarly to `factorial_for()`—and returns a value as an output (lines 9–12)—differently from `factorial_for()`, which returns the variable `factorial`. The main difference is in the function body, where `factorial_for()` contains a for loop, whereas `factorial_rec()` contains an if/else construct (lines 15–22). In this construct, if `n` is greater than 1 (line 16), we return the output of `factorial_rec()` calculated for the consecutive smaller integer—that is, `n - 1`—multiplied by `n` (line 18); otherwise (line 20), we return 1 (line 22).

Noticed anything unusual? In the first statement (line 18), we call `factorial_rec()` itself! This is because a recursive function is a function that calls itself several times until it reaches a base case. In other words, recursive functions create a cascade of function openings and executions until a certain point where the path is reversed to return the outputs and close the functions.

Let’s understand this mechanism better with the help of Figure8.3.

![Figure 8.3: The mechanism of a recursive function.](PythonPathways%201e9c242da244801f9e94cc2f55e9a45b/image%208.png)

Figure 8.3: The mechanism of a recursive function.

Figure 8.3 contains four major components. 

1. First, there is the initial function call `fact = factorial_rec(4)` (corresponding to line 25 in cell 2)—see the top left of Figure 8.3. 
2. Second, there are four simplified representations of `factorial_rec()` in cascade, each of them contained in a gray rectangle and indicated as (a), (b), (c), and (d), respectively. 
3. Third, there are orange arrows and numerical squares representing the “way down,” that is, the consecutive openings of several `fact = factorial_rec()` with their current inputs. 
4. And fourth, there are black arrows and numerical squares constituting the “way up,” that is, the return of the outputs and the closure of the functions.

Now, let’s see how these components interact with each other. When we call `fact = factorial_rec(4)`, we begin the “way down”—as indicated by the first, straight orange arrow and open a cascade of functions as follows:

- In (a), `n` is 4—that is, the initial input—thus the header of the function is `def factorial_rec(4)`. The if condition is `if 4 > 1`, which is true, so we move to the following statement containing the call `factorial_rec(3)`—3 is calculated from `n - 1`, that is, `4 - 1`. From here, we follow the orange arrow and move to (b), leaving the function open in (a) and temporarily disregarding all its remaining code.
- In (b), `n` is 3, so the header is `def factorial_rec(3)`. The if condition is now `if 3 > 1`, which is true again, so we move to the following statement where we call `factorial_rec(2)`. Thus, we follow the orange arrow and move to (c), leaving the function open in (b) and temporarily disregarding all its remaining code.
- In (c), `n` is 2, thus the header is `def factorial_rec(2)`. The if condition is `if 2 > 1`, which is true once more, so we move to the following statement where we call `factorial_rec(1)`. Again, we follow the orange arrow and move to (d), leaving the function open in (c) and temporarily disregarding all its remaining code.
- In (d), `n` is 1, thus the header is `def factorial_rec(1)`. The if condition is `if 1 > 1`, which is false! Therefore, we skip the statement under the if and we directly go to the statement under the else, which says `return 1`. We have reached the so-called base case.

At this point, we start the “way up.” Let’s go through the black numerical squares and arrows to collect the returned values and close the functions:

- In (d), the return is 1 and we pass it to the function call in (c), as indicated by the black arrow. The function in (d) is terminated.
- In (c), we complete the return statement under the if conditions—that is, `return factorial_rec(1) * 2`. Thus, we multiply the output of `factorial_rec(1)`, which is 1 from (d), by 2, obtaining 2, which we pass to the function call in (b), as indicated by the black arrow. The function in (c) is terminated.
- In (b), we complete again the return statement under the if conditions. Thus, we multiply the output of `factorial_rec(2)`, which is 2 from (c), by 3 and we obtain 6, which we pass to the function call in (a), as indicated by the black arrow. The function in (b) is terminated.
- Finally, in (a), we complete the return statement under the if condition for the last time. We multiply the output of `factorial_rec(3)`, which is 6 from (b), by 4, obtaining 24, which we pass to the output variable `fact` in the initial call, as indicated by the last black arrow. The function in (a) is terminated, as well as the whole recursion.

Now that the functioning mechanism is clear, let’s briefly formalize the syntax of recursive functions. They typically contain an if/else construct where statements return or print a value. One of the two statements is called the base case because it ensures that the recursion will stop—in our example, `return 1` (line 22). The other statement is called the recursive case because it contains a call to the function itself—in our example, `return factorial_rec(n - 1) * n` (line 18).

Let’s conclude with some advantages and disadvantages of recursive functions. On the one hand, recursive functions contain compact code and are appropriate when solving intrinsically recursive problems—see the "In more depth" session at the end of this chapter. On the other hand, they are computationally expensive because each call occupies space in memory, which is released only when closing the functions during the “way up.” Finally, recursive functions can be challenging to debug.

### **Recap**

- Iterative functions contain a loop to repeat some code.
- Recursive functions call themselves to repeat some code.
- Recursive functions typically contain an if/else construct, where one statement is the base case, and the other is the recursive case.
- Recursive functions contain compact code and are appropriate for intrinsically recursive problems. However, they use a large amount of computational memory and can be harder to debug.
<!-- END section7 -->