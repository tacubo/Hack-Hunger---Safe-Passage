
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Properties;

public class Main {
    public static void main(String[] args){
        System.out.println("Starting");

        try {

            Class.forName("org.postgresql.Driver");
            System.out.println("Found driver");

            String url = "jdbc:postgresql://10.1.106.228/safepassage";
            Properties props = new Properties();

            props.setProperty("user", "safepassageuser");
            props.setProperty("password", "safepassage");
            //props.setProperty("ssl", "true");
            Connection conn = DriverManager.getConnection(url, props);
            System.out.println("connected " + conn);
        } catch (SQLException se){
            System.out.println("Error getting connection");
            se.printStackTrace();
        } catch (ClassNotFoundException cnfe){
            System.out.println("Error finding classes");
            cnfe.printStackTrace();
        }
    }
}
