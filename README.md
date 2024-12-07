# Personal-Accounting

## To run this test task, please follow the below steps after clone the project from github.

1. Duplicate `.env.example` file to `.env` file, and config DB settings.
2. 
```
composer install
```
3.
```
php artisan key:generate
```
4.
```
php artisan db:create personal_accounting
```
5.
```
php artisan migrate
```
6. (account for test: [email => test@example.com, password => password])
```
php artisan db:seed
```
7.
```
composer dump-autoload
```
8.
```
php artisan serve
```

## API endpoints

```
login:
URI: {{baseurl}}/api/login
Method: POST
Payload: email, password
```

```
get transactions list:
URI: {{baseurl}}/api/transactions
Method: GET
Params: title, type, amount_min, amount_max, start_date, end_date
```

```
get specific transaction:
URI: {{baseurl}}/api/transactions/{{transaction_id}}
Method: GET
```

```
create a new transaction:
URI: {{baseurl}}/api/transaction
Method: POST
Payload: amount, title
```

```
delete an existing transaction:
URI: {{baseurl}}/api/transaction/{{transaction_id}}
Method: DELETE
```

## Answers to the questions in the test task
### Как в Вашем проекте используются принципы SOLID
#### В микро-масштабах на уровне кода классов
- Single Responsibility Principle (SRP): Each class is responsible for only one purpose:

Drivers (e.g., `JsonCurrencyDriver`, `XmlCurrencyDriver`) are responsible only for fetching and parsing data.
`TransactionController` is responsible only for transaction-related API operations.
`CurrencyDriverFactory` handles creating driver instances.
- Open/Closed Principle (OCP): Classes are open for extension but closed for modification:

Adding new drivers (e.g., a new `ApiCurrencyDriver`) requires no modification of existing classes; it just involves creating a new driver and registering it in the factory.
- Liskov Substitution Principle (LSP): The drivers (`JsonCurrencyDriver`, `XmlCurrencyDriver`, `CsvCurrencyDriver`) inherit from `CurrencyDriver` and can be used interchangeably wherever `CurrencyDriver` is expected.
- Interface Segregation Principle (ISP): Not directly implemented in this task as no unnecessary interfaces were created, but abstract classes like `CurrencyDriver` ensure subclasses only implement required methods.
- Dependency Inversion Principle (DIP): High-level modules (e.g., `CurrencyConverterFacade`) do not depend on low-level modules (e.g., drivers) but on abstractions (`CurrencyDriver`).
#### В макро-масштабе на уровне архитектуры системы
- Controller-Model Separation: The controller handles API requests, and models handle database logic.
- Middleware: Responsibilities like updating `last_seen` or checking authentication are moved to middleware, following the SRP.
- Factory Pattern: The factory dynamically selects the appropriate driver, ensuring scalability and maintainability.
- Caching and Broadcasting: The use of Laravel's built-in systems (e.g., caching, events) ensures modularity and extensibility without custom solutions.
### Что по Вашему означает правильное использование PHPDoc? Приведите примеры в Вашем коде
1. Describing Classes and Methods:
- Clearly explaining the purpose and behavior of the code.
- Specifying parameter types, return types, and any exceptions thrown.
2. Improving Readability and Collaboration:
- Helps other developers understand the code without diving into implementation details.
- Supports IDE autocompletion and error detection.
### Что Вам понравилось или не понравилось в PHP 7+?
<b>What I like:</b>
1. Type Declarations:
2. Null Coalescing Operator (??):
3. Anonymous Classes:
4. Improved Performance:
5. Throwable and Error Handling:
6. Spaceship Operator (<=>):

<b>What I dislike:</b>
1. Backward Compatibility Issues:
2. Limited Strict Typing:

### Как вы относитесь к типизации в PHP 7? Когда стоит использовать, когда нет? На Ваш взгляд...
<b>Advantages of Typing:</b>
- Code Reliability
- Improved Readability
- Better Tooling

<b>Disadvantages of Typing:</b>
- Overhead in Small Projects
- Dynamic Nature of PHP

<b>When to Use Typing:</b>
- Use typing when building large, collaborative, or long-term projects where clarity and reliability are essential

<b>When to Avoid Typing:</b>
- Avoid typing in experimental or rapid prototyping code where requirements might frequently change.
- For highly dynamic or polymorphic code where strict typing might lead to verbose or redundant checks.

## 🤣 Enjoy 🤣