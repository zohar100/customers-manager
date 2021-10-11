<?php
class Customer
{
    // DB stuff
    private $conn;
    private $table = 'customers';

    // Post Properties
    public ?int $id = null;
    public ?int $type_id = null;
    public string $type_name;
    public string $name;
    public int $phone;
    public string $email;
    public string $fav_products;
    public string $address;
    public string $gender;
    public string $image;
    public string $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Customers
    public function read()
    {
        // Create query
        $query = 'SELECT t.name as type_name, t.id, c.*
                                FROM ' . $this->table . ' c
                                LEFT JOIN
                                  types t ON c.type_id = t.id
                                ORDER BY
                                  c.created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Customer
    public function read_single()
    {
        // Create query
        $query = 'SELECT t.name as type_name, t.id, c.*
                    FROM ' . $this->table . ' c
                    LEFT JOIN
                    types t ON c.type_id = t.id
                    WHERE c.id = ?
                    LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->type_id = $row['type_id'];
        $this->type_name = $row['type_name'];
        $this->name = $row['name'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->fav_products = $row['fav_products'];
        $this->address = $row['address'];
        $this->gender = $row['gender'];
        $this->image = $row['image'];
        $this->created_at = $row['created_at'];
    }

    // Search For Customers
    public function search($search)
    {
        $search = "%$search%";
        // Create query
        $query = 'SELECT t.name as type_name, t.id, c.*
                        FROM ' . $this->table . ' c
                        LEFT JOIN
                        types t ON c.type_id = t.id
                        WHERE 
                        CONCAT(c.name, " ",
                        c.phone, " ",
                        c.id, " ") LIKE :search';

        // Prepare statement
        $stmt = $this->conn->prepare($query);


        // Bind params
        $stmt->bindParam(':search', $search);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create Customer
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table .
            ' SET type_id = :type_id, name = :name, phone = :phone, 
            email = :email, fav_products = :fav_products, 
            address = :address, gender = :gender, image = :image';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->type_id = htmlspecialchars(strip_tags($this->type_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fav_products = htmlspecialchars(strip_tags($this->fav_products));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->gender = htmlspecialchars(strip_tags($this->gender));

        $json = file_get_contents("https://thatcopy.pw/catapi/rest/");
        $response = json_decode($json);

        // Bind data
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':fav_products', $this->fav_products);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':image', $response->url);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Customer
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
