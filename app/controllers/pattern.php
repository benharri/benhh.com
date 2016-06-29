<?php

switch($pattern){
/////////////////////////
// BEHAVIORAL PATTERNS //
/////////////////////////

case "command":
  $page_header = "Command";
  $problem = "We need to be able to issue requests to objects without knowing anything about how the requested operation is implemented or anything about the receiver of the request.";
  $solution = "Issue requests by sending an object (or a representation of one to the receiver. That way we can plug different receivers in easily, just making sure they will understand the request.";
  $discussion = "By sending the request as an object,  we will be able to undo the operation easily. The purpose of the Command pattern is twofold: to separate interface and time: the requester is isolated from the requestee and the response doesn't always need to be completed immediately.";
  $examples = "Encapsulating requests as objects is the Command pattern. The check at a restaurant is an example of the Command pattern. A member of the wait staff takes a command (the customer's food order) and stores that by writing it on the check. The order is then queued in the kitchen to be prepared. The request object (check) is not necessarily dependent on the menu, and therefore can support commands to cook many different items with many variations.";
  $code_explanation = "We separate the request as a Command object and pass it to <code>foo</code> and <code>bar</code>.";
  $code_examples = <<<'EOT'
interface Command{ void execute();}

static class foo implements Command{
  public void execute(){
    System.out.println("quux");
  }
}
static class bar implements Command{
  public void execute(){
    System.out.println("baz");
  }
}

public static List generateRequests(){
  List queue = new ArrayList();
  queue.add(new foo());
  queue.add(new bar());
  return queue;
}
public static void doRequests(List queue){
  for(Iterator iter = queue.iterator(); it.hasNext();){
    ((Command)iter.next()).execute();
  }
}

public static void main(String[] args){
  List queue = generateRequests();
  doRequests(queue);
}
// output:
quux
baz
EOT;
  $related_patterns = array("Observer", "Chain of Responsibility", "Memento (mementos can be used to maintain the state for undo operations)");
  break;


case "observer":
  $page_header = "Observer";
  $problem = "Large design doesn't scale well as new graphics and monitoring requirements are added.";
  $solution = "Establish a one-to-many dependency between objects so that when a state changes, all dependents are notified and updated automatically. A &quot;Model&quot; object maintains data and business logic. It can be connected to an external storage device or other implementation of data storage. Observers register themselves with the Model (Subject) when they are created. Any changes to the Subject are broadcast to all Observers.";
  $discussion = "Essentially, we are separating the data from its representation. This allows the view to be pluggable and dynamic: the number and type of view objects can be configured on the fly.";
  $examples = "One of the most common examples of the Observer pattern is the View part of Model-View-Controller systems. One central Model is designated the Subject for all Observer objects, which query for relevant data when they receive an <code>update()</code> broadcast. <br><br> A real-world example would be an auction: The auctioneer is the Subject and all bidders are Observers. When the auctioneer accepts a bid, all bidders are notified vocally.";
  $code_explanation = "Here, two Observers are created on a Subject subj in C++. When the value of subj changes to 20, obs1 and obs2 are notified, which calls their <code>update()</code> method.";
  $code_examples = <<<'EOT'
class Observer{
  int value;
public:
  Observer(Subject *model, int value){
    model->attach(this);
    this.value = value;
  }
  void update(int value){
    cout << value << " mod "<< this.value << " = " << value % this.value << endl;
  }
}
class Subject{
  int value;
  vector views;
public:
  notify(){
    for(int i = 0; i < views.size(); i++) views[i]->update(value);
  }
  setVal(int value){
    this.value = value;
  }
  attach(Observer *obs){
    views.push(obs);
  }
}
int main(){
  Subject subj;
  Observer obs1(&subj, 3);
  Observer obs2($subj, 4);
  subj.setVal(20);
}
// output:
20 mod 3 = 2
20 mod 4 = 0
EOT;
  $related_patterns = array("Mediator", "Command", "Chain of Responsibility");
  break;


case "mediator":
  $page_header = "Mediator";
  $problem = "Designing reusable components generally results in the &quot;spaghetti code&quot; phenomenon. Dependencies between pieces tend towards all or nothing.";
  $solution = "Represent the interactions between objects in a system with a Mediator object. The many-to-many relationships between peers is promoted to &quot;full object status&quot;.";
  $discussion = "Colleagues (or peers) do not interact with each other directly. Instead, they speak with the Mediator, which knows and conducts the others. It's important to note that not all interacting objects would benefit from mutual decoupling, however it can be useful to abstract those interactions into a new class.";
  $examples = "The Mediator pattern could be useful in the design of a user and group permissions system in an operating system. If a group can have zero or more users, and a user can be a member of zero or more groups, the Mediator pattern provides a flexible approach to mapping and managing users and groups. <br><br> An Air Traffic Control center at a busy airport represents the Mediator in a real-world situation. Instead of each airplane talking to all the others, they only speak with the control tower. Since the tower has knowledge of where all other planes are, they can best direct planes individually on when to take off and land.";
  $code_explanation = "Rather than having a Node keep track of its own next Node and pointers, abstract that away into a List Mediator. This handles things like deleting the head Node.";
  $code_examples = <<<'EOT'
class Node{
private:
  int value;
public:
  Node(int v){value = v;}
  int get_val(){return value;}
}

class List{
private:
  vector list;
  public:
  add_node(Node *n){list.push(n);}
  add_node(int v){list.push(new Node(v));}
  void traverse(){
    for(int i = 0; i < list.size(); i++) cout << list[i]->get_val();
    cout << endl;
  }
  void remove_node(int v){
    for(vector::iterator iter = list.begin(); iter != list.end(); ++iter){
      if((*iter)->get_val() == v){
        list.erase(iter);
        break;
      }
    }
  }
}
EOT;
  $related_patterns = array("Chain of Responsibility", "Command", "Observer", "Facade (in that it abstracts the functionality of existing classes)");
  break;


case "visitor":
  $page_header = "Visitor";
  $problem = "Collections are data types widely used in object oriented programming. They often contain objects of varying types and operations will need to be performed on all the elements in a collection without prior knowledge of the types.";
  $solution = "The visitor pattern represents an operation to be performed on each element of a structure. We define a new operation without changing the classes of the elements by defining <code>visit()</code> and <code>accept()</code> methods.";
  $discussion = "The main purpose of the visitor pattern is to abstract away functionality that can be applied to any number of objects within a hierarchy (collection) of objects. This encourages building lightweight element classes because processing is no longer among the list of responsibilities. New functionality can easily be added to the original inheritance hierarchy by simply adding a new Visitor subclass. <br> The visitor pattern is generally not a good match if the object hierarchy is unstable or if the public interface for the candidate objects is insufficient for the access that Visitor classes will require.";
  $examples = "We use the Visitor pattern to represent an operation to be performed on elements of an object structure without chaning the classes of objects upon which it operates. A real world example would be the operation of a pizza delivery company. When a person calls the restaurant, the operator on the phone places the order for them. Other employees begin making the pizza. The task of making food visits several other people on the way to the customer, namely the delivery driver.";
  $code_explanation = "This is the beginnings of a Visitor framework for the parsing of a arithmetic expression parse tree.";
  $code_examples = <<<'EOT'
  public abstract class Node
  {
    public abstract Double eval();
  }
  public class OpNode extends Node
  {
    public Node left, right;
    private String operator;
    <T, K> T accept(NodeVisitor<T, K> visitor, K k);
  }
  public class Leaf extends Node
  {
    public Double value;
    public Double eval(){
      return value;
    }
    <T, K> T accept(NodeVisitor<T, K> visitor, K k);
  }

  public interface NodeVisitor<T, K>{ // here we use generics
    T visitLeaf(Leaf leaf, K k);
    T visitOpNode(OpNode node, K k);
  }
  public class EvalVisitor implements NodeVisitor<Double, Void>{
    public Double visitNumber(Leaf leaf, Void p){
      return leaf.eval();
    }
    public Double visitOpNode(OpNode opnode, Void p){
      switch(opnode.getOperator()){
        case '+': return opnode.left.accept(this, p) + opnode.right.accept(this, p);
        case '-': return opnode.left.accept(this, p) - opnode.right.accept(this, p);
        case '*': return opnode.left.accept(this, p) * opnode.right.accept(this, p);
        case '/': return opnode.left.accept(this, p) / opnode.right.accept(this, p);
      }
    }
  }
EOT;
  $related_patterns = array("Double Dispatch", "Iterator", "Composite");
  break;


case "interpreter":
  $page_header = "Interpreter";
  $problem = "Certain problems occur often, in a well-defined and well-understood domain.";
  $solution = "If the domain of these problems were characterized with a language, the problems could easily be solved with an interpretation engine. Map a problem's domain to a language, the language to a grammar, and the grammar to a hierarchical design.";
  $discussion = "This pattern suggests modeling the domain of a problem as a recursive grammar. Each rule can reference other rules or terminate (a leaf node in a tree structure). When a problem can easily be represented in this manner, the Interpreter pattern defines a useful solution.";
  $examples = "Musical notation used by musicians is an example of a language and grammar to be interpreted by the Interpreter (the musicians themselves).";
  $code_explanation = "This code snippet is an interpreter for Roman Numerals. They are outputted as a decimal number.";
  $code_examples = <<<'EOT'
var Context = function(input){
  this.input = input;
  this.output = 0;
}
Context.prototype.startsWith = function(str){
  return this.input.substr(0, str.length) === str;
}

var Expression = function(name, one, four, five, multiplier){
  this.name = name;
  this.one = one;
  this.four = four;
  this.five = five;
  this.multiplier = multiplier;
}
Expression.prototype.interpret = function(context){
  if(context.input.length == 0) return;
  else if(context.startsWith(this.nine)){
    context.output += (9*this.multiplier);
    context.input = context.input.substr(2);
  }
  else if(context.input.startsWith(this.four)){
    context.output += (4*this.multiplier);
    context.input = context.input.substr(2);
  }
  else if(context.input.startsWith(this.five)){
    context.output += (5*this.multiplier);
    context.input = context.input.substr(1);
  }
  while(context.input.startsWith(this.one)){
    context.output += (1*this.multiplier);
    context.input = context.input.substr(1);
  }
}

function run(){
  var roman = "MCMXXVIII";
  var context = new Context(roman);
  var tree = [];

  tree.push(new Expression("thousand", "M", " ", " ", " ", 1000));
  tree.push(new Expression("hundred",  "C", "CD", "D", "CM", 100));
  tree.push(new Expression("ten",      "X", "XL", "L", "XC", 10));
  tree.push(new Expression("one",      "I", "IV", "V", "IX", 1));

  for(var i = 0; i < tree.length; i++) tree[i].interpret(context);

  console.log(roman + "=" + context.output);
}
EOT;
  $related_patterns = array("Composite", "State", "Flyweight (to share terminal symbols)");
  break;


case "iterator":
  $page_header = "Iterator";
  $problem = "Need to be able to traverse diverse data structures in a common abstract way.";
  $solution = "The main principle is to take the responsibility for access and traversal out of the data structure and put that into an Iterator object.";
  $discussion = "Iterators are fundamental to &quot;generic programming&quot;, which seeks to boost productivity by reducing configuration costs.";
  $examples = "A real-world example is the seek button on a radio. Though you may know the frequency of several stations, you may want to simply get to the next one. The seek button iterates to the next available station.";
  $code_explanation = "Generally, iterators keep track of where it is in the structure. In Lua, the generic for loop keeps track of that. Though the iterator is often tricky to write, the use of that iterator is very easy.";
  $code_examples = <<<'EOT'
function allwords ()
  local line = io.read()  -- current line
  local pos = 1           -- current position in the line
  return function ()      -- iterator function
    while line do         -- repeat while there are lines
      local s, e = string.find(line, "%w+", pos)
      if s then           -- found a word?
        pos = e + 1       -- next position is after this word
        return string.sub(line, s, e)     -- return the word
      else
        line = io.read()  -- word not found; try next line
        pos = 1           -- restart from first position
      end
    end
    return nil            -- no more lines: end of traversal
  end
end

for word in allwords() do
  print(word)
end
EOT;
  $related_patterns = array("Visitor", "Composite", "Memento (Iterators can store the current position as a Memento)", "Factory (to instantiate appropriate subclasses if uncommon types are used)");
  break;


case "memento":
  $page_header = "Memento";
  $problem = "Sometimes we would like to store an object's state in order to restore that later. How do we support &quot;undo&quot; and &quot;rollback&quot; operations?";
  $solution = "Give the object whose state you would like to save the ability to serialize its internal state. The &quot;Memento&quot; created when the object is serialized is stored in a stack-like fashion by some storage object. When we would like to restore the state, the storage object requests the Originator object to recreate the state based on the Memento.";
  $discussion = "Source object is the only actor able to access the insides of a Memento. The storage object (&quot;caretaker&quot;) only knows when to tell the object to create a Memento and when to restore it.";
  $examples = "In combination with a stack of Command objects, unlimited &quot;undo&quot; and &quot;redo&quot; can be easily implemented. <br><br> Iterators can be implemented to use a Memento to store the current state of an iteration.";
  $code_explanation = "Here we have three Java classes: Memento, Originator, and Manager. Originator has additional temporary data that is not necessary to restore a state from. The Manager class is the caretaker of the Mementos: we can add and get Mementos from the Manager. Note that there is no way to modify the information in a Memento after is creation.";
  $code_examples = <<<'EOT'
class Memento{
  private String state;
  public Memento(String state){this.state = state;}
  public getSavedState(){return state;}
}
class Originator{
  private String state;
  public void set(String state){this.state = state;}
  public Memento saveToMemento(){return new Memento(state);}
  public void restoreFromMemento(Memento m){state = m.getSavedState();}
}
class Manager{
  private ArrayList<Memento> savedStates = new ArrayList<Memento>();
  public void addMemento(Memento m){savedStates.add(m);}
  public Memento getMemento(int index){return savedStates.get(index);}
}

class Demo{
  public static void main(String[] args){
    Manager manager = new Manager();
    Originator originator = new Originator();
    originator.set("foo");
    manager.addMemento(originator.saveToMemento());
    originator.set("bar");
    manager.addMemento(originator.saveToMemento());
    originator.set("baz");
    originator.restoreFromMemento(manager.getMemento(1));
  }
}
EOT;
  $related_patterns = array("Command", "Iterator");
  break;


case "chainofresponsibility":
  $page_header = "Chain of Responsibility";
  $problem = "The number of handlers (nodes) and number of processes can vary. We need to process requests without hard-coding a precedence relationship mapping.";
  $solution = "Avoid coupling the sender of a request with the recipient. Chain the receiving objects and pass the request along until it is marked done somehwhere down the line.";
  $discussion = "Chain of Responsibility simplifies object interactions. The recursive chain allows an arbitrary number of links to be added without prior knowledge of it. Essentially a linked list for processing requests.";
  $examples = "A real-world example of the Chain of Responsibility pattern is a cash distribution module inside an ATM: The desired amount is passed to the tray for the largest bill denomination where bills are dispensed until the next bill would exceed that amount. The request is passed on to the next smallest denomination until the desired amount is met.";
  $code_explanation = "This Java sample demonstrates the abstraction of the Chain of Responsibility. The task gets passed to the appropriate Processor (where a pseudo-random int determines the busy state, for demonstration purposes). When the Processor is not &quot;busy&quot;, it <code>process()</code>es the proper Image.";
  $code_examples = <<<'EOT'
interface Image{
  String process();
}

static class Sepia implements Image{
  public String process(){return "Sepia";}
}
static class BW implements Image{
  public String process(){return "B/W";}
}

static class Processor{
  private static java.util.Random rand = new java.util.Random();
  private static int nextId = 1;
  private int id = nextId++;
  public boolean handle(Image img){
    if(rand.nextInt(2) != 0){
      System.out.println("Processor " + id + " is busy.");
      return false;
    }
    System.out.println("Processor " + id + ": " + img.process());
    return true;
  }
}

public static void main(String[] args){
  Image[] imgs = {new Sepia(), new BW(), new BW(), new Sepia(), new BW()};
  Processor[] processors = {new Processor(), new Processor(), new Processor()};
  for(int i = 0, j; i < input.length; i++){
    j = 0;
    while(!procs[j].handle(imgs[i])) j = (j+1) % processors.length;
  }
}
EOT;
  $related_patterns = array("Command", "Mediator", "Observer", "Composite");
  break;


case "templatemethod":
case "template":
  $page_header = "Template Method";
  $problem = "When two (or more) components do not share common interface or implentation but do have significant functional similarities, duplicate effore will be expended to make one change to both.";
  $solution = "Define the skeleton of an algorithm, allowing the most important parts to be filled in by client subclasses. The Template Method pattern lets subclasses tweak parts of an algorithm to suit its purpose without changing the algorithm itself.";
  $discussion = "The algorithm designer decides which parts of the algorithm are standard to all subclasses and which parts are variable (left to the subclasses to define). Variable parts can be given a default implementation or left purposely blank.";
  $examples = "The Template pattern is used prominently in the design and implementation of frameworks. Placeholders are left in place for the user to fill in as needed. This pattern book uses the Template pattern extensively: common headers are templated and included where needed.";
  $code_explanation = "This function generates the HTML markup (including the proper CSS classes) for a Bootstrap Dropdown Menu from an associative array of links. If the first level is a link, it is included directly in the markup. Otherwise, if an item contains an array (meant here as a submenu), menu items are added for each link in the submenu array. This helps reduce the need for messy HTML markup and also we can change the menu with one change to a menu array (when we are using a common header).";
  $code_examples = <<<'EOT'
  function build_bootstrap_dropdown_menu($arr){
    $ret = "";
    foreach($arr as $name => $val){
      if(is_array($val)){
        $ret .= "<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
          aria-haspopup="true" aria-expanded="false">$name<span class="caret"></span></a><ul class="dropdown-menu">";
        foreach($val as $name => $href) $ret .= "<li><a href=\"$href\">$name</a></li>";
        $ret .= "</ul></li>";
      }
      else{
        $ret .= "<li><a href=$val>$name</a></li>";
      }
    }
    return $ret;
  }
EOT;
  $related_patterns = array("Strategy", "Factory (specialization of Template Method)");
  break;


case "state":
  $page_header = "State";
  $problem = "Large objects often function differently at run-time based upon an internal state.";
  $solution = "Allow objects to change behavior depending on state. It is essentially an object-based state machine.";
  $discussion = "The large object can behave like an object of a different class would, but this is based on an internal state representation. State objects are often Singletons.";
  $examples = "Most electric machines are examples of state machines. For example, a washing machine can be in several states: mid-cycle (door locked), mid-cycle (interruptable, door unlocked), powered on and ready to start, or off. Actions from the user cause the machine to react in different ways.";
  $code_explanation = "The Chain is <code>pull()</code>'d every time that a line is read from stdin. The state of the pullchain cycles through, giving a different behavior depending on the current state.";
  $code_examples = <<<'EOT'
class Chain{
  private int state;
  public Chain(){state = 0;}
  public void pull(){
    if(state > 3) state++;
    else state = 0;
    System.out.println(state);
  }
}

public class Demo{
  public static void main(String[] args) throws IOException{
    InputStreamReader ins = new InputStreamReader(System.in);
    int ch;
    Chain chain = new Chain();
    while(true){
      System.out.print("Press enter");
      ch = is.read();
      ch = is.read();
      chain.pull();
    }
  }
}
EOT;
  $related_patterns = array("Wrapper", "Singleton", "Strategy", "Bridge");
  break;


case "strategy":
  $page_header = "Strategy";
  $problem = "A standard value of software development has been &quot;maximize cohesion and minimize coupling&quot;. Over time, objects become more entwined and less flexible to new implementations.";
  $solution = "Define a family of interchangeable encapsulated algorithms. The Strategy pattern allows the algorithm to vary based on the clients that use it.";
  $discussion = "Clients should prefer interfaces rather than direct connections with peer objects. An interface can represent an abstract base class or the method signatures to be expected.";
  $examples = "Different modes of transportation to an arbitrary goal are an example of a Strategy. Any of the different modes will get a traveler to the destination, which can be applied based on tradeoffs between convenience, speed, and cost.";
  $code_explanation = "The <code>Comparator.sort()</code> method in the Java utils is a great example of the Strategy pattern. By implementing the Comparator in our class, we can override the <code>compare()</code> method and then make our own compare algorithm based on the compareMode set during initialization.";
  $code_examples = <<<'EOT'
public class PersonComparator implements Comparator<Person>{
  public static final int COMPARE_BY_FIRST_NAME = 0;
  public static final int COMPARE_BY_LAST_NAME = 1;
  public static final int COMPARE_BY_AGE = 2;
  private int compareMode = 1;

  public PersonComparator(){}
  public PersonComparator(int compareMode){
    this.compareMode = compareMode;
  }

  @Override
  public int compare(Person p1, Person p2){
    switch(compareMode){
    case COMPARE_BY_FIRST_NAME:
      return p1.firstName.compareTo(p2.firstName);
    case COMPARE_BY_LAST_NAME:
      return p1.lastName.compareTo(p2.lastName);
    default:
      return p1.age.compareTo(p2.age);
    }
  }
}
class Person{
  public String firstName;
  public String lastName;
  public int age;
  public Person(String first, String last, int newAge){
    firstName = first;
    lastName = last;
    age = newAge;
  }
}
EOT;
  $related_patterns = array("Template Method", "State", "Decorator", "Bridge", "Adapter", "Flyweight");
  break;

/////////////////////////
// CREATIONAL PATTERNS //
/////////////////////////

case "factory":
  $page_header = "Factory";
  $problem = "Within the standardized model context of a framework, we need to provide for the instantiation of is internal objects.";
  $solution = "Define an interface for instantiation. Defer instantiation to subclasses when appropriate.";
  $discussion = "The added complexity of Factory object instantiation adds a great deal of customization to a design. Factory is unnecessary if the class of the created object never changes or if the initialization is easily overridden.";
  $examples = "The Factory pattern draws its name from an actual factory - which is a great example of the Factory pattern. Base materials enter and final products leave. The type of final product created depends on the internal workings of the factory itself.";
  $code_explanation = "This is a simple example of a Factory Method in C++. <code>Fubar::make_fubar()</code> returns a proper new instance of the subtype that you select in the main loop.";
  $code_examples = <<<'EOT'
class Fubar{
public:
  static Fubar *make_fubar(int c);
  virtual void print_name();
}

int main(){
  vector fubars;
  int choice;
  while(1){
    cout << "Foo(1) Bar(2) or Quux(3)? Do(0) ";
    cin >> choice;
    if(!choice) break;
    fubars.push(Fubar::make_fubar(choice));
  }
  for(int i = 0; i < roles.size(); i++) fubars[i]->print_name();
  for(int i = 0; i < roles.size(); i++) delete fubars[i];
}

class Foo: public Fubar{
public:
  void print_name(){cout << "Foo" << endl;}
}
class Bar: public Fubar{
public:
  void print_name(){cout << "Bar" << endl;}
}
class Quux: public Fubar{
  public:
  void print_name(){cout << "Quux" << endl;}
}

Fubar *Fubar::make_fubar(int c){
  if(c == 1) return new Foo;
  else if(c == 2) return new Bar;
  else return new Quux;
}
EOT;
  $related_patterns = array("Template Method (Factory is to object instantiation as Template Method is to algorithm implementation)", "Abstract Factory", "Prototype (creation through delegation, as Factory is creation through inheritance)");
  break;


case "doubledispatch":
  $page_header = "Double Dispatch";
  $problem = "Sometimes the computational path in a program needs to differ based on the runtime arguments it was called with.";
  $solution = "The Double Dispatch pattern prescribes a mechanism to call different concrete functions depending on the types of objects involved in the call.";
  $discussion = "Double Dispatch is prominently used in the Visitor pattern, where different operations on an object produce different results based on the type of the calling object.";
  $code_examples = <<<'EOT'
class foo{
public:
  virtual void foobar(foo& f);
}
class bar{
  void foobar(foo& f){
    cout << "Foo" << endl;
  }
  void foobar(int& i){
    cout << "I am an int" << endl;
  }
public:
  void getType(foo& f){
    f.foobar(*this);
  }
}
EOT;
  $code_explanation = "Foo and bar are C++ classes. If <code>bar::foobar()</code> is called, the overloaded method will be selected based on the type of the argument selected by the method signature.";
  $examples = "The Visitor pattern usees an implementation of Double Dispatch.";
  $related_patterns = array("Visitor");
  break;


case "prototype":
  $page_header = "Prototype";
  $problem = "The <code>new</code> operator hard-wires the type of object to be created.";
  $solution = "Specify the kinds of objects you'd like to be able to create, build a prototypical instance of that, and create new objects by cloning those prototypes.";
  $discussion = "Clients <code>clone()</code> the abstract base class, supplying an optional data type designating the desired subtype. The <code>new</code> operator is abandoned in favor of prototype cloning.";
  $examples = "JavaScript uses prototypes extensively for object creation. The object constructor function in JS is the prototype for that object (which can be called with the <code>new</code> operator).";
  $code_explanation = "JavaScript has string built-in support for prototypes:";
  $code_examples = <<<'EOT'
var myprototype = function myprototypeobj(){
  this.foo = function(){alert("foo");};
  this.bar = function(){alert("bar");};
}
var myobj.prototype = myprototype;
myobj.foo(); myobj.bar(); // myobj is created with the methods of myprototype
EOT;
  $related_patterns = array("Factory (creation through inheritance, where Prototype is creation through delegation)", "Abstract Factory", "Composite", "Decorator", "Singleton");
  break;


case "abstractfactory":
  $page_header = "Abstract Factory";
  $problem = "Application portability between platforms is often not considered in advance. The application will need to support different databases, windowing systems, and operating systems. Case statements with options for each platform to be supported begin to appear everywhere throughout the codebase.";
  $solution = "Provide an interface for creating families of related and dependent objects without specifying their concrete classes. Create a hierarchy that can encapsulate the appropriate constructions for each supported platform.";
  $discussion = "The Abstract Factory defines a Factory Method per product. Clients never create platform objects directly. Instead, they ask the Abstract Factory to do that. Because the service provided is so pervasive, it is often implemented as a Singleton.";
  $examples = "A real-world example of the Abstract Factory pattern would be part stamping machines in an actual factory. When different parts need to be stamped, a different form can be swapped into the presses.<br><br>A software example would be the ToolBuilder in SmallTalk. Using the ToolBuilder, we can easily plug different windowing systems, among others, into our application.";
  $code_explanation = "This snippet is an example in C# of an Abstract Factory. The appropriate factory object (which knows how to create the UI elements for that platform) is created at run-time.";
  $code_examples = <<<'EOT'
interface IButton{
  void Paint();
}
interface IGUIFactory{
  IButton CreateButton();
}

class WinFactory: IGUIFactory{
  public IButton CreateButton(){
    return new WinButton();
  }
}
class OSXFactory: IGUIFactory{
  public IButton CreateButton(){
    return new OSXButton();
  }
}
static void Main(){
  var appearance = Settings.Appearance;
  IGUIFactory factory;
  switch(appearance){
    case Appearance.Win:
      factory = new WinFactory();
      break;
    case Appearance.OSX:
      factory = new OSXFactory();
      break;
    default:
      throw new System.NotImplementedException();
  }
  var button = factory.CreateButton();
  button.paint();
}
EOT;
  $related_patterns = array("Prototype", "Factory Method", "Builder", "Singleton", "Facade");
  break;


case "lazyinitialization":
  $page_header = "Lazy Initialization";
  $problem = "The creation of some objects is sometimes costly.";
  $solution = "Delay the creation of such an object until it is first needed. Augment the creation methods to not run until the object is used for the first time.";
  $discussion = "Lazy Initialization will often speed the start-up of a system, as it avoids pre-allocation of large objects. However, it can have negative effects on the overall performance as the expensive object creation pops up when those are needed. The key benefit is that you can often avoid the creation of objects that are never used.";
  $examples = "One example is a database connection object. We can create the object to hold the connection, but the connection will not be made until we actually need to query or insert to the database. If we never actually need to interact with the database, the connection will not be made.";
  $code_explanation = "This is a Python snippet that delays the initialization of a Fruit until it is actually used.";
  $code_examples = <<<'EOT'
class Fruit(obj):
    def __init__(self, sort):
        self.sort = sort

class Fruits(obj):
    def __init__(self):
        self.sorts = {}
    def get_fruit(self, sort):
        if sort not in self.sorts:
            self.sorts[sort] = Fruit[sort]
        return self.sorts[sort]

if __name__ == '__main__':
    fruits = Fruits()
    print fruits.get_fruit('Apple')
    print fruits.get_fruit('Banana')
EOT;
  $related_patterns = array("Factory Method", "Abstract Factory");
  break;


case "builder":
  $page_header = "Builder";
  $problem = "Applications need to create the elements of a complex structure. Sometimes the specifications for such elements exist on a different device or storage medium than where they need to be created.";
  $solution = "Separate the construction process so that different representations of the structure can be created. Add the ability to create several targets from a complex representation.";
  $discussion = "The focus of the Builder pattern is on creating complex aggregate structures. If many possible representations of a given common input are needed, then the abstraction gained from the Builder pattern will be very useful.";
  $examples = "SmallTalk's ToolBuilder is a combination of the Builder and Abstract Factory patterns. Creating a kids meal at a fast food restaurant is a real-world example of the Builder pattern. The common input is the kids meal: each component can be customized by the customer to create a unique representation of the kids meal.";
  $code_explanation = "This is a sample Burger Builder in C#. In this way, we can customize the Burger that is created by the Builder.";
  $code_examples = <<<'EOT'
public class Burger{
  public Burger(){}
  public int Toppings{get; set;}
  public string Bun{get; set;}
}

public interface IBurgerBuilder{
  void SetBun([NotNull]string bun);
  void SetToppings([NotNull]int count);
  Burger GetResult();
}

public class BurgerBuilder: IBurgerBuilder{
  private Burger _burger;
  public BurgerBuilder(){this._burger = new Burger();}
  public void SetBun(string bun){this._burger.Bun = bun;}
  public void SetToppings(int count){this._burger.Toppings = count;}
  public Car GetResult(){return this._burger;}
}

public class BurgerBuildDirector{
  public Burger Construct(){
    BurgerBuilder builder = new BurgerBuilder();
    builder.setBun("Sesame");
    builder.setToppings(2);
    return builder.GetResult();
  }
}
EOT;
  $related_patterns = array("Abstract Factory", "Prototype", "Singleton", "Composite");
  break;


case "singleton":
  $page_header = "Singleton";
  $problem = "An application needs one and only one instance of a core object.";
  $solution = "Ensure that a class has only one instance. Provide a global interface to that instance.";
  $discussion = "The Singleton pattern is one of the most misused patterns in software engineering. When is Singleton unnecessary? Most of the time. The real problem with Singletons is they provide such a good excuse to not carefully consider the appropriate public and private elements of an object.";
  $examples = "State, Abstract Factory, and Builder objects are often implemented as Singletons. When there is one and only one of an object, the Singleton pattern can be applied.";
  $code_explanation = "This is a C++ snippet of a Singleton. The <code>Singleton</code> class is defined globally and will only have one instance of itself.";
  $code_examples = <<<'EOT'
class Singleton{
  int val;
public:
  Singleton(int v = 0){val = v;}
  int get_value(){return val;}
  void set_value(int v){val = v;}
}
Singleton *singleton = 0;

void foo(){
  if(!singleton) singleton = new Singleton;
  singleton->set_value(1);
  cout << "foo: Singleton is " << singleton->get_value() << endl;
}
void bar(){
  if(!singleton) singleton = new Singleton;
  singleton->set_value(2);
  cout << "bar: Singleton is " << singleton->get_value() << endl;
}

int main(){
  if(!singleton) singleton = new Singleton;
  cout << "main: Singleton is " << singleton->get_value() << endl;
  foo(); bar();
}
// output:
main: Singleton is 0
foo: Singleton is 1
bar: Singleton is 2
EOT;
  $related_patterns = array("State", "Prototype", "Abstract Factory", "Facade");
  break;


case "nullobject":
  $page_header = "Null Object";
  $problem = "Conditional code adds bloat and decreases speed as the logic branches further and further.";
  $solution = "We create a object that implements the desired interface and helps to eliminate conditional code by defining the behavior by defining a default behavior for an empty body.";
  $discussion = "The Null Object is very predictable and allows us to test certain conditions without explicitly checking them in a conditional. It's useful precisely because it does nothing.";
  $examples = "We can iterate through a linked list. The last node in the chain will be a Null node. When we access it, it halts the iteration process. That way, we don't have to check each node to see if it's null, the standard way to check the existence. The end-of-list behavior we are trying to create is defined in our Null Object, therefore eliminating the need for costly conditionals.";
  $code_explanation = "This Null List allows us to visit the entire list (See <a href=\"/patternbook/visitor\">Visitor</a> Pattern). If we don't use the Null Object, we would get many NullObjectExceptions. With it, the Null Object itself knows what to do.";
  $code_examples = <<<'EOT'
public abstract class List{
  public abstract List getTail();
}

public class LList extends List{
  private Object head;
  private Object next;
  public LList(Object head, Object next){
    this.head = head;
    this.next = next;
  }
  public Object getHead(){return head;}
  public List getNext(){return next;}
}
public NullList extends List{
  private static final NullList instance = new NullList();
  private NullList(){}
  public static NullList Singleton(){return instance;}
  public List getNext(){return this;}
}
EOT;
  $related_patterns = array("Iterator", "State", "Strategy", "Singleton (Null Objects are Singletons)");
  break;


/////////////////////////
// STRUCTURAL PATTERNS //
/////////////////////////

case "facade":
  $page_header = "Facade";
  $problem = "A complex system needs a public interface. The inner workings of that system should not be available to every other system.";
  $solution = "Provide a simplified public interface for the use by other systems. Wrap the whole complicated thing in that interface.";
  $discussion = "Providing the interface lowers the learning curve required to successfully utilize our system by other clients. It also promotes decoupling from other potential clients. On the other hand, it could limit the features and flexibility available to &quot;power users&quot;.";
  $examples = "A website can be a Facade to a more complicated subsystem. For example, databases can be accessed and updated from the web, a common task accomplished by server-side scripting. The user only interacts with the public website, which hides the inner complexity of the actual system.";
  $code_explanation = "Here, FooFacade is a Facade for Foo and Bar. When we call <code>foo.start()</code> from main, the internals of the Facade are also initialized.";
  $code_examples = <<<'EOT'
class Foo{
public:
  quuz(){cout << "quuz" << endl;}
  quux(){cout << "quux" << endl;}
}
class Bar{
public:
  baz(){cout << "baz" << endl;}
  qux(){cout << "qux" << endl;}
}

class FooFacade{
private:
  Foo foo; Bar bar;
public:
  FooFacade(){
    this.foo = new Foo();
    this.bar = new Bar();
  }
  start(){
    foo.quuz();
    foo.quux();
    bar.baz();
    bar.qux();
  }
}

int main(){
  FooFacade foo = new FooFacade();
  foo.start();
}
// output:
quuz
quux
baz
qux
EOT;
  $related_patterns = array("Adapter", "Flyweight", "Mediator", "Abstract Factory");
  break;


case "composite":
  $page_header = "Composite";
  $problem = "An application needs to manipulate a combination of primitive and complex objects. If the handling differs between those, it would be undesirable to always query the type of object being handled.";
  $solution = "Compose objects into recursive tree structures to represent hierarchies. Define an abstract base class that specifies the behavior to be exercised uniformly across all primitive and composite objects.";
  $discussion = "Each Composite object only couples itself with the abstract type as it manages its children. Use this pattern whenever you have composites than can contain either components or other composites.";
  $examples = "Arithmetic expressions can be represented as Composites. Each operand is the root of a tree. Child nodes can be other operands or a number, a terminal node. With the abstract class, we can treat this Composite as one expression and let the Composite handle that.";
  $code_explanation = "This JavaScript snippet defines a tree structure where a node can have some value as its <code>name</code> and any number of children in an array.";
  $code_examples = <<<'EOT'
var Node = function(name){
  this.children = [];
  this.name = name;
}
Node.prototype = {
  add:function(child){
    this.children.push(child);
  },
  remove:function(child){
    for(var i = 0; i < this.children.length; i++){
      if(this.children[i] === child){
        this.children.splice(i, 1);
        return;
      }
    }
  },
  getChild:function(i){return this.children[i];}
  hasChildren:function(){return this.children.length > 0}
}

function traverse(indent, node){
  console.log(Array(indent++).join("--") + node.name);
  for(var i = 0; i < node.children.length; i++){
    traverse(indent, node.getChild(i));
  }
}
EOT;
  $related_patterns = array("Decorator", "Iterator", "Chain of Responsibility", "Mediator", "Flyweight (on terminal symbols in leaf nodes)");
  break;


case "decorator":
  $page_header = "Decorator";
  $problem = "We want to add functionality to a static object, which is not possible using Inheritance because it is static and would apply that to the entire class.";
  $solution = "Attach additional functionality to the object dynamically by wrapping it recursively on the client-side.";
  $discussion = "Ensure that we have a single core component and several optional embellishments. The Decorator class attaches additional responsibilities as needed.";
  $examples = "The ornaments we put on a Christmas tree are examples of embellishments added by the Decorator. Regardless of how many things we add, it will still be recognizable as a Christmas tree. The added functionality would be the ability to light the tree up.";
  $code_explanation = "Python has built-in support for decorators.";
  $code_examples = <<<'EOT'
def debug_pop_stack(func):
  def debug_print_caller(func):
    print('() was called')
  return debug_print_caller

@debug
def foo(a, b, c):
  print(a, b, c)

#output:
foo was called
EOT;
  $related_patterns = array("Adapter", "Proxy", "Composite", "Chain of Responsibility");
  break;


case "future":
  $page_header = "Future";
  $problem = "Some parts of the application require other parts, and may be as yet undefined. We need to test the existing part without writing the whole application.";
  $solution = "Define a wrapper class to handle a message that has yet to come.";
  $discussion = "The Future pattern is very useful for asynchronous operations, as well as during active development.";
  $examples = "We could implement a database connection as a Future. That means we can use the shell interface until we are able to set up the database and connect that properly.";
  $code_explanation = "Here, the implementation of Future can be changed in the future to reflect other parts of the system.";
  $code_examples = <<<'EOT'
class Future{
  int toBeImplemented;
public:
  Future(int f){toBeImplemented = f;}
  int getval(){return toBeImplemented;}
}
int main(){
  Future f = new Future(3);
}
EOT;
  $related_patterns = array("Facade", "Proxy", "Adapter", "Bridge");
  break;


case "bridge":
  $page_header = "Bridge";
  $problem = "Applications that try to support many platforms often end up becoming brittle and bloated. Alternate implementations are locked in at compile time to their interfaces.";
  $solution = "Create another layer of abstraction: decouple the abstraction from its implementation so the two can vary independently. Goes beyond encapsulation to insulation. This allows run-time flexibility compared to compile-time flexibility.";
  $discussion = "The Bridge pattern is applicable when you need run-time binding of client implementation and when you need to share an implementation among several objects. Applying the Bridge pattern results in a decoupled object interface while improving extensibility and hiding unnecessary details from clients.";
  $examples = "The action of a switching something on and off can be represented with the Bridge pattern. When you need to switch something, the Bridge will decide at run-time what kind of switch we're interacting with and perform the correct operation, be it a normal lightswitch, a pull-chain, or some sort of knob.";
  $code_explanation = "<code>Bridge</code> is a Bridge for Shapes and Windows.";
  $code_examples = <<<'EOT'
class Shape{
  $x; $y;
}
class Window{
  $w; $h;
}

class Bridge{
  $shape = new Shape(400, 500);
  $window = new Window(800, 600);
}
EOT;
  $related_patterns = array("Adapter (Adapter makes intends to make things work after they're designed, while Bridge intends to make them work before they're designed)", "State", "Strategy", "Abstract Factory");
  break;


case "adapter":
  $page_header = "Adapter";
  $problem = "A new component or dependency is not compatible with the current system architecture.";
  $solution = "Convert the interface for the incompatible object into something that the rest of the system expects and understands. Wrap an existing class with a new interface.";
  $discussion = "Just as we use adapters for hardware, software often needs an adapter to ease communication between the parts. The Adapter pattern is about creating an intermediary interface object that we can use to talk to incompatible or legacy components.";
  $examples = "Many adapters are found in the real world. Display cables are found in several variations (VGA, DVI, DisplayPort, HDMI). The display device that you would like to connect to does not always have the same port as your device. We use adapters to enable the use of these cables and displays.";
  $code_explanation = "A database interface in any language is an adapter for systems that aren't directly compatible.";
  $code_examples = <<<'EOT'
$db = new OracleOCI('localhost', 'sys', 'password', 'schema');

$query = "select * from DUAL";
$results = $db->query($query);
while($data = oci_fetch_object($results)) echo $data->DUMMY;
EOT;
  $related_patterns = array("Bridge (Bridge intends to make things work as they are bring designed, Adapter intends to make older incompatible things work with the current system)", "Proxy", "Decorator", "Facade");
  break;


case "flyweight":
  $page_header = "Flyweight";
  $problem = "Using objects to define a system all the way down to the most specific level provides optimal flexibility, but we often find recurring, related object types at a low level. Creating and managing these objects is unacceptably expensive in terms of memory usage and performance.";
  $solution = "Share objects to support many related objects efficiently.";
  $discussion = "Flyweight variations are stored in the repository of the application's Factory. Flyweight is generally only useful when the object overhead in a system reaches a critical point.";
  $examples = "Storing each graphical glyph for text is an extremely bloated way to store that information. Instead, a commonly-known code for that glyph is stored. When we need to display that again, we pull the glyph corresponding to that code from the local Factory's repository.";
  $code_explanation = "ASCII is a Flyweight for characters. The ASCIIchar class prints the internal values as an int and as a char, to represent the table of characters with a value.";
  $code_examples = <<<'EOT'
class ASCIIchar{
private:
  int c; char ch;
public:
  ASCIIchar(int c){
    this.c = c;
    ch = c;
  }
  void print(){
    cout << (int)c << " " << ch << endl;
  }
}
ASCIIchar foo = new ASCIIchar(65);
ASCIIchar bar = new ASCIIchar(110);

int main(){
  foo->print();
  bar->print();
}
EOT;
  $related_patterns = array("Factory", "Composite", "Facade", "State", "Interpreter");
  break;


case "proxy":
  $page_header = "Proxy";
  $problem = "An application needs to support certain resource-hungry objects and operations. We would like to avoid instantiating such objects or performing such operations until they are needed.";
  $solution = "Provide a placeholder shell object that can control access to the real object.";
  $discussion = "There are several common use cases of the Proxy pattern: <ul><li>Placeholder for objects that are expensive to create</li><li>Placeholder for remote objects in other address spaces</li><li>Protective placeholder for sensitive information (such as database operations or administrator tasks)</li></ul>";
  $examples = "A debit card is a real-world Proxy for money held in a checking account. It can be used as cash in most cases, as it is a good surrogate for physical money. It controls access to the funds in the account.";
  $code_explanation = "Here, the ProxyPlaceholder will hold a dummy object until <code>DBConnection</code> is implemented. Additionally, once it is implemented, it will be the interface to that DBConnection. We can use that to interface with the database, changing nothing once it's implemented.";
  $code_examples = <<<'EOT'
class ProxyPlaceholder{
  DBConnection db;
public:
  ProxyPlaceholder(){db = new DBConnection;}
  getCon(){return db;}
}
int main(){
  string query = "select * from PERSONS";
  ProxyPlaceholder db = new ProxyPlaceholder();
  db->query(query);
}
EOT;
  $related_patterns = array("Adapter", "Decorator", "Future");
  break;


default:
  header("Location: http://euclid.nmu.edu/~benharri/patternbook/?error&notfound=$pattern"); die();
  break;

}

$pattern_info = array(
  'page_header'      => $page_header . " Pattern",
  'problem'          => $problem,
  'solution'         => $solution,
  'discussion'       => $discussion,
  'examples'         => $examples,
  'related_patterns' => $related_patterns,
  'code_explanation' => $code_explanation,
  'code_examples'    => $code_examples,
);


?>
