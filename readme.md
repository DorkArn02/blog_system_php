# Webprogramming I. final project

## Project description

This is a simple blog system in PHP in which you can create posts and comments. Before you start posting you must create a new account, then login with your username and password combination.

## Database

In this project I used MySQL database. There are 3 tables in the database: posts, comments, users.

**Users table:**

| Attribute name    | type    |
|----------|---------|
| id (PK)      | INT     |
| username | VARCHAR(255) |
| password | VARCHAR(255) |
| email    | VARCHAR(255) |

**Posts table:**

| Attribute name    | type    |
|----------|---------|
| id (PK)      | INT     |
| title | VARCHAR(255) |
| description | TEXT |
| content    | TEXT |
| user_id (FK)    | INT |
| created    | DATE |

**Comments table:**

| Attribute name    | type    |
|----------|---------|
| id (PK)      | INT     |
| content    | TEXT |
| user_id (FK)    | INT |
| post_id (FK)    | INT |
| created    | DATETIME |

## Project screenshots

![image](https://user-images.githubusercontent.com/28065716/210362471-e6d01f73-3178-4777-91e2-3f3f2ab0d4c2.png)

![image](https://user-images.githubusercontent.com/28065716/210362602-cc34d4e5-9499-4e55-b03d-ac38f3541cbd.png)

![image](https://user-images.githubusercontent.com/28065716/210362729-e7957bcd-b386-4077-8398-71984532c8da.png)

![image](https://user-images.githubusercontent.com/28065716/210362789-d4cbb74c-df1d-4016-a4e9-4a48dd0a14b0.png)

![image](https://user-images.githubusercontent.com/28065716/210363143-e4650557-3ff9-466c-8918-99020aa6e426.png)

## Rich text editor

I used this rich text editor in my project: https://www.tiny.cloud/