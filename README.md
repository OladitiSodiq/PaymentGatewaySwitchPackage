

## Payment Gateway Switch Package Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Use Cases](#use-cases)
6. [Testing](#testing)
7. [License](#license)

---

## Introduction
The `PaymentsGatewaySwitch` package allows easy switching between two different payment gatewayswhich are fluuterwaveand paystack based on configurable rules. It automatically selects the best available gateway based on criteria such as availability, balance, and currency compatibility.

## Installation

### Step 1: Install via Composer
You can install the package using Composer. Run the following command in your Laravel project directory:

```bash
composer require oladitisodiq/PaymentsGatewaySwitch

```

## Use Case Examples
1. Payment Gateway is Unavailable
1. Payment Gateway Balance is insufficient 
1. Payment Gateway is Unavailable