// #include <iostream>
// #include <unordered_map>
// #include <string>
// #include <vector>

// using namespace std;

// // Supplier Class to hold supplier details
// class Supplier {
// public:
//     int id;
//     string name;
//     string contact;

//     // Default constructor
//     Supplier() : id(0), name(""), contact("") {}

//     // Parameterized constructor
//     Supplier(int id, const string& name, const string& contact)
//         : id(id), name(name), contact(contact) {}
// };

// // Product Class to hold product details
// class Product {
// public:
//     int id;
//     string name;
//     int quantity;
//     float price;

//     // Default constructor
//     Product() : id(0), name(""), quantity(0), price(0.0) {}

//     // Parameterized constructor
//     Product(int id, const string& name, int quantity, float price)
//         : id(id), name(name), quantity(quantity), price(price) {}
// };

// // Order Class to track orders placed by customers
// class Order {
// public:
//     int orderID;
//     int productID;
//     int quantity;
//     float totalCost;

//     Order(int orderID, int productID, int quantity, float totalCost)
//         : orderID(orderID), productID(productID), quantity(quantity), totalCost(totalCost) {}
// };

// // SCMS Class to manage the supply chain processes
// class SCMS {
// private:
//     unordered_map<int, Supplier> suppliers;
//     unordered_map<int, Product> inventory;
//     vector<Order> orders;

// public:
//     // Add Supplier to the system
//     void addSupplier(int id, const string& name, const string& contact) {
//         suppliers[id] = Supplier(id, name, contact);
//         cout << "Supplier added: " << name << "\n";
//     }

//     // Add Product to the inventory
//     void addProduct(int id, const string& name, int quantity, float price) {
//         inventory[id] = Product(id, name, quantity, price);
//         cout << "Product added: " << name << "\n";
//     }

//     // Display all Suppliers
//     void displaySuppliers() {
//         cout << "\n--- Suppliers List ---\n";
//         for (const auto& s : suppliers) {
//             cout << "ID: " << s.first << ", Name: " << s.second.name
//                  << ", Contact: " << s.second.contact << "\n";
//         }
//     }

//     // Display all Products in the inventory
//     void displayInventory() {
//         cout << "\n--- Inventory List ---\n";
//         for (const auto& p : inventory) {
//             cout << "ID: " << p.first << ", Name: " << p.second.name
//                  << ", Quantity: " << p.second.quantity << ", Price: " << p.second.price << "\n";
//         }
//     }

//     // Place an Order and update inventory
//     void orderProduct(int orderID, int productID, int quantity) {
//         if (inventory.find(productID) != inventory.end()) {
//             if (inventory[productID].quantity >= quantity) {
//                 float totalCost = inventory[productID].price * quantity;
//                 inventory[productID].quantity -= quantity;
//                 orders.push_back(Order(orderID, productID, quantity, totalCost));
//                 cout << "Order placed for " << quantity << " of "
//                      << inventory[productID].name << ". Total cost: $" << totalCost
//                      << ". Remaining stock: " << inventory[productID].quantity << "\n";
//             } else {
//                 cout << "Not enough stock for product: " << inventory[productID].name << "\n";
//             }
//         } else {
//             cout << "Product not found.\n";
//         }
//     }

//     // Generate an Order Report
//     void generateOrderReport() {
//         cout << "\n--- Order Report ---\n";
//         for (const auto& o : orders) {
//             cout << "Order ID: " << o.orderID << ", Product ID: " << o.productID
//                  << ", Quantity: " << o.quantity << ", Total Cost: $" << o.totalCost << "\n";
//         }
//     }

//     // Generate an Inventory Report
//     void generateInventoryReport() {
//         cout << "\n--- Inventory Report ---\n";
//         displayInventory();
//     }

//     // Generate Supplier Report
//     void generateSupplierReport() {
//         cout << "\n--- Supplier Report ---\n";
//         displaySuppliers();
//     }
// };

// int main() {
//     SCMS scms; // Create an instance of the SCMS class
//     int choice;
//     int orderID = 1;

//     while (true) {
//         // Display Menu for User Input
//         cout << "\n--- Supply Chain Management System ---\n";
//         cout << "1. Add Supplier\n2. Add Product\n3. Display Suppliers\n";
//         cout << "4. Display Inventory\n5. Order Product\n6. Generate Order Report\n";
//         cout << "7. Generate Inventory Report\n8. Generate Supplier Report\n9. Exit\n";
//         cout << "Enter your choice: ";
//         cin >> choice;

//         if (choice == 1) {
//             int id;
//             string name, contact;
//             cout << "Enter Supplier ID: ";
//             cin >> id;
//             cin.ignore(); // Clear input buffer before getline
//             cout << "Enter Supplier Name: ";
//             getline(cin, name);
//             cout << "Enter Supplier Contact: ";
//             getline(cin, contact);
//             scms.addSupplier(id, name, contact);
//         } else if (choice == 2) {
//             int id, quantity;
//             float price;
//             string name;
//             cout << "Enter Product ID: ";
//             cin >> id;
//             cin.ignore(); // Clear input buffer before getline
//             cout << "Enter Product Name: ";
//             getline(cin, name);
//             cout << "Enter Quantity: ";
//             cin >> quantity;
//             cout << "Enter Price: ";
//             cin >> price;
//             scms.addProduct(id, name, quantity, price);
//         } else if (choice == 3) {
//             scms.generateSupplierReport();
//         } else if (choice == 4) {
//             scms.generateInventoryReport();
//         } else if (choice == 5) {
//             int productID, quantity;
//             cout << "Enter Product ID: ";
//             cin >> productID;
//             cout << "Enter Quantity to Order: ";
//             cin >> quantity;
//             scms.orderProduct(orderID++, productID, quantity);
//         } else if (choice == 6) {
//             scms.generateOrderReport();
//         } else if (choice == 7) {
//             scms.generateInventoryReport();
//         } else if (choice == 8) {
//             scms.generateSupplierReport();
//         } else if (choice == 9) {
//             cout << "Exiting...\n";
//             break;
//         } else {
//             cout << "Invalid choice. Please try again.\n";
//         }
//     }

//     return 0;
// }

#include <iostream>
#include <fstream>
#include <string>
#include <iomanip>

using namespace std;

// Function to add a supplier
void addSupplier(const string &id, const string &name, const string &contact) {
    ofstream file("suppliers.txt", ios::app);
    if (file.is_open()) {
        file << id << "," << name << "," << contact << endl;
        cout << "Supplier added successfully: " << name << endl;
    } else {
        cout << "Error opening suppliers file" << endl;
    }
}

// Function to add a product
void addProduct(const string &id, const string &name, int quantity, double price) {
    ofstream file("products.txt", ios::app);
    if (file.is_open()) {
        file << id << "," << name << "," << quantity << "," << fixed << setprecision(2) << price << endl;
        cout << "Product added successfully: " << name << endl;
    } else {
        cout << "Error opening products file" << endl;
    }
}

// Function to place an order
void placeOrder(const string &orderId, const string &productId, int quantity) {
    ofstream file("orders.txt", ios::app);
    if (file.is_open()) {
        file << orderId << "," << productId << "," << quantity << endl;
        cout << "Order placed successfully: " << orderId << endl;
    } else {
        cout << "Error opening orders file" << endl;
    }
}

// Main function to parse commands
int main(int argc, char *argv[]) {
    if (argc < 2) {
        cout << "Invalid command. Usage: scms <command> [arguments]" << endl;
        return 1;
    }

    string command = argv[1];

    if (command == "addSupplier") {
        if (argc == 5) {
            addSupplier(argv[2], argv[3], argv[4]);
        } else {
            cout << "Usage: scms addSupplier <id> <name> <contact>" << endl;
        }
    } else if (command == "addProduct") {
        if (argc == 6) {
            addProduct(argv[2], argv[3], stoi(argv[4]), stod(argv[5]));
        } else {
            cout << "Usage: scms addProduct <id> <name> <quantity> <price>" << endl;
        }
    } else if (command == "placeOrder") {
        if (argc == 5) {
            placeOrder(argv[2], argv[3], stoi(argv[4]));
        } else {
            cout << "Usage: scms placeOrder <orderId> <productId> <quantity>" << endl;
        }
    } else {
        cout << "Unknown command: " << command << endl;
    }

    return 0;
}
