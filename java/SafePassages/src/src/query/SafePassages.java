package query;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class SafePassages {

    private static final String SELECT_SCHOOL_NAMES =
            "select school_nam from safepassages";

    public List<String> getSchoolNames(Connection connection) throws SQLException {
        List<String> names = new ArrayList<>();

        Statement statement = connection.createStatement();

        ResultSet rs = statement.executeQuery(SELECT_SCHOOL_NAMES);
        while (rs.next()) {
            String name = rs.getString("school_nam");
            names.add(name);
        }

        return names;
    }
}
