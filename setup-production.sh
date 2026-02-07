#!/bin/bash

# ================================
# Mail-ER Production Setup Script
# ================================

echo "🚀 Starting Mail-ER Production Setup..."
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from the project root.${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Clearing all caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

echo -e "${YELLOW}Step 2: Running database migrations...${NC}"
php artisan migrate --force
echo -e "${GREEN}✓ Migrations complete${NC}"
echo ""

echo -e "${YELLOW}Step 3: Seeding database...${NC}"
php artisan db:seed --class=DatabaseSeeder --force
php artisan db:seed --class=MainPageSeeder --force
echo -e "${GREEN}✓ Database seeded${NC}"
echo ""

echo -e "${YELLOW}Step 4: Creating storage link...${NC}"
php artisan storage:link
echo -e "${GREEN}✓ Storage linked${NC}"
echo ""

echo -e "${YELLOW}Step 5: Optimizing for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Optimization complete${NC}"
echo ""

echo -e "${YELLOW}Step 6: Setting permissions...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✅ Production setup complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "1. Update .env file with your database credentials"
echo "2. Run: php artisan key:generate"
echo "3. Create admin user via tinker"
echo "4. Test the application"
echo ""
echo -e "${YELLOW}Admin Panel:${NC} /admin/login"
echo ""
