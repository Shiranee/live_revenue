# Use the official PostgreSQL image as the base
FROM postgres:15

# Set environment variables for database configuration
ENV POSTGRES_DB=public
ENV POSTGRES_USER=admin
ENV POSTGRES_PASSWORD=12345678

# Expose the default PostgreSQL port
EXPOSE 5432

# Copy initialization scripts if needed (e.g., to create tables or populate data)
# Uncomment the following line if you have .sql or .sh scripts
# COPY ./init-scripts /docker-entrypoint-initdb.d/

# Default command (inherited from the postgres base image)
CMD ["postgres"]
