# Api dev Server

A dummy Api Server, log all http requests into a file and return a 200 message

## Usage

### Run the container

`docker run --rm -p8080:80 willoucom/apidev`

### Web UI

Go to `http://localhost:8080/_/`

### Log requests

Go to `http://localhost:8080/examples/foo/bar?test=true`

You will see a new entry in the web UI and a new file inside the container in the folder `/tmp`

### Flush history

To flush the list, delete and re-create the container OR enter the container and remove `/tmp/*.log`

## Limitations

This service only returns a header 200 with an empty body, any requests using GET and/or response body may throw an error in your application

The GUI is ugly

## Roadmap

- Better GUI
- Route interceptor to forge custom response
