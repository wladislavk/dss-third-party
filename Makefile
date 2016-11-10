.PHONY: base
base:
	docker build -t ds3_base .

.PHONY: all
all: base
	docker-compose build
