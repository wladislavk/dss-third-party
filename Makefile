.PHONY: base
base:
	docker build -t ds3-base .

.PHONY: all
all: base
	docker-compose build
