import fs from 'fs/promises'
import path from 'path'
import bcrypt from 'bcryptjs'

export default defineEventHandler(async (event) => {
  try {
    const body = await readBody(event) // Get request data
    const { name, surname, username, password } = body

    // Validate input
    if (!name || !surname || !username || !password) {
      return { success: false, error: 'All fields are required!' }
    }

    // Normalize username to lowercase (avoids duplicate usernames due to case differences)
    const normalizedUsername = username.trim().toLowerCase()

    // Define the path to the JSON file
    const filePath = path.resolve('server/data/people.json')

    // Read existing users
    let users = []
    try {
      const fileData = await fs.readFile(filePath, 'utf-8')
      users = fileData ? JSON.parse(fileData) : [] // Handle empty file case
    } catch (error) {
      console.warn('No existing file found or error reading file, creating a new one.')
    }

    console.log("Existing Users:", users) // Debugging log

    // Check if username already exists
    if (users.some(user => user.username === normalizedUsername)) {
      return { success: false, error: 'Username already taken!' }
    }

    // Hash the password before storing
    const hashedPassword = await bcrypt.hash(password, 10)

    // Add new user with hashed password
    users.push({ name, surname, username: normalizedUsername, password: hashedPassword })

    // Save back to file
    await fs.writeFile(filePath, JSON.stringify(users, null, 2), 'utf-8')

    return { success: true, message: 'User registered successfully!' }
  } catch (error) {
    console.error('Error:', error)
    return { success: false, error: error.message }
  }
})
